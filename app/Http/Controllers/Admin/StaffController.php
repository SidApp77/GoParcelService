<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Drivers\Gd\Driver;

class StaffController extends Controller
{
    // Show staff list page (optional)
    public function index(Request $request)
    {
        $query = Staff::orderBy('created_at', 'DESC');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }

        $staffs = $query->paginate(10)->appends(['search' => $request->search]);

        return view('admin.staff.list', ['staffs' => $staffs]);
    }

    // Show create staff page
    public function create()
    {
        $roles = $this->getRoleOptions();

        return view('admin.staff.create', compact('roles'));
    }


    public function getRoleOptions()
    {
        // Get column type from information_schema
        $type = DB::select("SHOW COLUMNS FROM staff WHERE Field = 'role'")[0]->Type;

        // $type looks like: enum('admin','user','manager')

        // Extract the enum values as an array
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enumValues = [];

        if (isset($matches[1])) {
            $enumValues = str_getcsv($matches[1], ',', "'");
        }

        return $enumValues;
    }

    // Store new staff member
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|min:6',
            'phone' => 'required',
            'role' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('admin.staff.create')->withInput()->withErrors($validator);
        }

        $staff = new Staff();
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->password = bcrypt($request->password);
        $staff->phone = $request->phone;
        $staff->role = $request->role;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $profileImageName = $this->handleImageUpload($request->file('profile_picture'), 'profile_pictures');
            $staff->profile_picture = $profileImageName;
        }

        // Handle ID proof upload
        if ($request->hasFile('id_proof')) {
            $idProofImageName = $this->handleImageUpload($request->file('id_proof'), 'id_proofs');
            $staff->id_proof = $idProofImageName;
        }

        $staff->save();

        return redirect()->route('admin.staff.list')->with('success', 'Staff added successfully.');
    }

    // Show edit staff page
    // public function edit($id)
    // {
    //     $staff = Staff::findOrFail($id);
    //     return view('admin.staff.edit', compact('staff'));
    // }

    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        $roles = $this->getRoleOptions();

        return view('admin.staff.edit', compact('staff', 'roles'));
    }

    // Update staff
    public function update($id, Request $request)
    {
        $staff = Staff::findOrFail($id);

        // Make sure $staff is defined before using it in validation rules
        $staff = Staff::findOrFail($id);

        $rules = [
            'name' => 'required|min:3',
            'email' => "required|email|unique:staff,email,{$staff->id}",
            'password' => 'nullable|min:6',
            'phone' => 'required',
            'role' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('admin.staff.edit', $staff->id)->withInput()->withErrors($validator);
        }

        $staff->name = $request->name;
        $staff->email = $request->email;
        if (!empty($request->password)) {
            $staff->password = bcrypt($request->password);
        }
        $staff->phone = $request->phone;
        $staff->role = $request->role;

        // Handle profile picture deletion
        if ($request->delete_profile_picture == '1') {
            $this->deleteStaffImage($staff->profile_picture, 'profile_pictures');
            $staff->profile_picture = null;
        }

        // Handle new profile picture upload
        if ($request->hasFile('profile_picture')) {
            $this->deleteStaffImage($staff->profile_picture, 'profile_pictures');
            $profileImageName = $this->handleImageUpload($request->file('profile_picture'), 'profile_pictures');
            $staff->profile_picture = $profileImageName;
        }

        // Handle ID proof deletion
        if ($request->delete_id_proof == '1') {
            $this->deleteStaffImage($staff->id_proof, 'id_proofs');
            $staff->id_proof = null;
        }

        // Handle new ID proof upload
        if ($request->hasFile('id_proof')) {
            $this->deleteStaffImage($staff->id_proof, 'id_proofs');
            $idProofImageName = $this->handleImageUpload($request->file('id_proof'), 'id_proofs');
            $staff->id_proof = $idProofImageName;
        }

        $staff->save();

        return redirect()->route('admin.staff.list')->with('success', 'Staff updated successfully.');
    }

    // Delete staff
    public function destroy(Request $request)
    {
        $staffId = $request->id;

        if (!$staffId) {
            session()->flash('error', 'Invalid request.');
            return response()->json([
                'status' => false,
                'message' => 'Invalid staff ID.',
            ]);
        }

        $staff = Staff::find($staffId);

        if (!$staff) {
            session()->flash('error', 'Staff not found');
            return response()->json([
                'status' => false,
                'message' => 'Staff not found.',
            ]);
        }

        // Delete profile picture and ID proof if they exist
        if ($staff->profile_picture) {
            $this->deleteStaffImage($staff->profile_picture, 'profile_pictures');
        }

        if ($staff->id_proof) {
            $this->deleteStaffImage($staff->id_proof, 'id_proofs');
        }

        $staff->delete();

        session()->flash('success', 'Staff deleted successfully.');
        return response()->json([
            'status' => true,
            'message' => 'Staff deleted successfully.',
        ]);
    }

    // Helper: Upload image and generate thumbnail
    protected function handleImageUpload($image, $folder)
    {
        $ext = $image->getClientOriginalExtension();
        $imageName = time() . '_' . uniqid() . '.' . $ext;

        $uploadPath = public_path("uploads/{$folder}");
        $thumbPath = public_path("uploads/{$folder}/thumb");

        // Create directories if they don't exist
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }
        if (!File::exists($thumbPath)) {
            File::makeDirectory($thumbPath, 0755, true);
        }

        // Move uploaded image to main folder
        $image->move($uploadPath, $imageName);

        // Create image manager instance and generate thumbnail
        $manager = new ImageManager(new Driver());
        $img = $manager->read($uploadPath . '/' . $imageName);
        $img->resize(1000, 1000); // Use fixed resize as per reference
        $img->save($thumbPath . '/' . $imageName);

        return $imageName;
    }

    // Helper: Delete image and thumbnail
    protected function deleteStaffImage($imageName, $folder)
    {
        if ($imageName) {
            $imagePath = public_path("uploads/{$folder}/" . $imageName);
            $thumbPath = public_path("uploads/{$folder}/thumb/" . $imageName);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            if (File::exists($thumbPath)) {
                File::delete($thumbPath);
            }
        }
    }
}

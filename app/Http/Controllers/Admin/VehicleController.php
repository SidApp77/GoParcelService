<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class VehicleController extends Controller
{
    // List all vehicles
    public function index(Request $request)
    {
        $query = Vehicle::orderBy('created_at', 'DESC');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            // adjust columns you want to search
            $query->where('registration_number', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%');
        }

        $vehicles = $query->paginate(10)->appends(['search' => $request->search]);

        return view('admin.vehicle.list', compact('vehicles'));
    }

    // Show create form
    public function create()
    {
        return view('admin.vehicle.create');
    }

    // Store new vehicle
    public function store(Request $request)
    {
        $rules = [
            'registration_number' => 'required|string|unique:vehicles,registration_number|max:50',
            'model'               => 'required|string|max:100',
            'capacity'            => 'required|numeric|min:1',
            // 'amenities'           => 'nullable|string',
            'is_active'           => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.vehicle.create')
                ->withInput()
                ->withErrors($validator);
        }

        $vehicle = new Vehicle();
        $vehicle->registration_number = $request->registration_number;
        $vehicle->model               = $request->model;
        $vehicle->capacity            = $request->capacity;
        // $vehicle->amenities           = $request->amenities;
        $vehicle->is_active           = $request->is_active;

        // If you plan to handle an uploaded photo later, include it; otherwise remove this block
        // if ($request->hasFile('vehicle_photo')) {
        //     $imageName = $this->handleImageUpload($request->file('vehicle_photo'), 'vehicles');
        //     $vehicle->photo = $imageName;
        // }

        $vehicle->save();

        return redirect()
            ->route('admin.vehicle.list')
            ->with('success', 'Vehicle added successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('admin.vehicle.edit', compact('vehicle'));
    }

    // Update vehicle
    public function update($id, Request $request)
    {
        $vehicle = Vehicle::findOrFail($id);

        $rules = [
            'registration_number' => "required|string|unique:vehicles,registration_number,{$vehicle->id}|max:50",
            'model'               => 'required|string|max:100',
            'capacity'            => 'required|numeric|min:1',
            // 'amenities'           => 'nullable|string',
            'is_active'           => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.vehicle.edit', $vehicle->id)
                ->withInput()
                ->withErrors($validator);
        }

        $vehicle->registration_number = $request->registration_number;
        $vehicle->model               = $request->model;
        $vehicle->capacity            = $request->capacity;
        // $vehicle->amenities           = $request->amenities;
        $vehicle->is_active           = $request->is_active;

        // If handling a photo delete/upload:
        // if ($request->delete_vehicle_photo == '1') {
        //     $this->deleteVehicleImage($vehicle->photo, 'vehicles');
        //     $vehicle->photo = null;
        // }
        // if ($request->hasFile('vehicle_photo')) {
        //     $this->deleteVehicleImage($vehicle->photo, 'vehicles');
        //     $imageName = $this->handleImageUpload($request->file('vehicle_photo'), 'vehicles');
        //     $vehicle->photo = $imageName;
        // }

        $vehicle->save();

        return redirect()
            ->route('admin.vehicle.list')
            ->with('success', 'Vehicle updated successfully.');
    }

    // Delete vehicle
    public function destroy(Request $request)
    {
        $vehicleId = $request->id;

        if (!$vehicleId) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid vehicle ID.',
            ]);
        }

        $vehicle = Vehicle::find($vehicleId);
        if (!$vehicle) {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle not found.',
            ]);
        }

        // If you have an image to delete:
        // if ($vehicle->photo) {
        //     $this->deleteVehicleImage($vehicle->photo, 'vehicles');
        // }

        $vehicle->delete();

        return response()->json([
            'status' => true,
            'message' => 'Vehicle deleted successfully.',
        ]);
    }

    // (Optional) Handle image uploads if you add photo later
    protected function handleImageUpload($image, $folder)
    {
        $ext = $image->getClientOriginalExtension();
        $imageName = time() . '_' . uniqid() . '.' . $ext;

        $uploadPath = public_path("uploads/{$folder}");
        $thumbPath = public_path("uploads/{$folder}/thumb");

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }
        if (!File::exists($thumbPath)) {
            File::makeDirectory($thumbPath, 0755, true);
        }

        $image->move($uploadPath, $imageName);

        $manager = new ImageManager(new Driver());
        $img = $manager->read("{$uploadPath}/{$imageName}");
        $img->resize(1000, 1000);
        $img->save("{$thumbPath}/{$imageName}");

        return $imageName;
    }

    // (Optional) Delete image file and thumbnail
    protected function deleteVehicleImage($imageName, $folder)
    {
        if ($imageName) {
            $imagePath = public_path("uploads/{$folder}/{$imageName}");
            $thumbPath = public_path("uploads/{$folder}/thumb/{$imageName}");

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            if (File::exists($thumbPath)) {
                File::delete($thumbPath);
            }
        }
    }
}

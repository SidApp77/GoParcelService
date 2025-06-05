<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $query = Route::orderBy('created_at', 'DESC');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('origin', 'like', "%$search%")
                  ->orWhere('destination', 'like', "%$search%");
        }

        $routes = $query->paginate(10)->appends(['search' => $request->search]);
        return view('admin.route.list', compact('routes'));
    }

    public function create()
    {
        return view('admin.route.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'distance' => 'required|integer|min:1',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'status' => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('admin.route.create')->withErrors($validator)->withInput();
        }

        Route::create($request->all());

        return redirect()->route('admin.route.list')->with('success', 'Route created successfully.');
    }

    public function edit($id)
    {
        $route = Route::findOrFail($id);
        return view('admin.route.edit', compact('route'));
    }

    public function update(Request $request, $id)
    {
        $route = Route::findOrFail($id);

        $rules = [
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'distance' => 'required|integer|min:1',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'status' => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('admin.route.edit', $route->id)->withErrors($validator)->withInput();
        }

        $route->update($request->all());

        return redirect()->route('admin.route.list')->with('success', 'Route updated successfully.');
    }

    public function destroy(Request $request)
    {
        $route = Route::find($request->id);

        if (!$route) {
            return response()->json([
                'status' => false,
                'message' => 'Route not found.'
            ]);
        }

        $route->delete();

        return response()->json([
            'status' => true,
            'message' => 'Route deleted successfully.'
        ]);
    }
}
@extends('layouts.admin')

@section('page-title', 'Vehicle')

@section('main')
    <div class="overflow-y-auto h-screen pb-10">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-semibold">Create Vehicle</h2>
                <a href="{{ route('admin.vehicle.list') }}"
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Back</a>
            </div>

            @include('layouts.message')

            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('admin.vehicle.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Registration Number -->
                        <div>
                            <label for="registration_number" class="block text-gray-700 font-medium mb-1">Registration Number</label>
                            <input
                                type="text"
                                id="registration_number"
                                name="registration_number"
                                value="{{ old('registration_number') }}"
                                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('registration_number') border-red-500 @enderror"
                                placeholder="Registration Number">

                            @error('registration_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Model -->
                        <div>
                            <label for="model" class="block text-gray-700 font-medium mb-1">Model</label>
                            <input
                                type="text"
                                id="model"
                                name="model"
                                value="{{ old('model') }}"
                                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('model') border-red-500 @enderror"
                                placeholder="Vehicle Model">

                            @error('model')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacity -->
                        <div>
                            <label for="capacity" class="block text-gray-700 font-medium mb-1">Capacity</label>
                            <input
                                type="number"
                                step="0.01"
                                id="capacity"
                                name="capacity"
                                value="{{ old('capacity') }}"
                                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('capacity') border-red-500 @enderror"
                                placeholder="Passenger Capacity">

                            @error('capacity')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amenities -->
                        {{-- <div>
                            <label for="amenities" class="block text-gray-700 font-medium mb-1">Amenities</label>
                            <textarea
                                id="amenities"
                                name="amenities"
                                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('amenities') border-red-500 @enderror"
                                placeholder="List amenities (e.g., Wi-Fi, AC, Recliner Seats)">{{ old('amenities') }}</textarea>

                            @error('amenities')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div> --}}

                        <!-- Is Active -->
                        <div>
                            <label for="is_active" class="block text-gray-700 font-medium mb-1">Is Active</label>
                            <select
                                name="is_active"
                                id="is_active"
                                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('is_active') border-red-500 @enderror">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>

                            @error('is_active')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center space-x-4 pt-4">
                        <button type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">Create</button>
                        <a href="{{ route('admin.vehicle.list') }}"
                            class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

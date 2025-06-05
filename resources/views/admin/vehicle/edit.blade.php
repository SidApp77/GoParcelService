@extends('layouts.admin')

@section('page-title', 'Edit Vehicle')

@section('main')
    <div class="overflow-y-auto h-screen pb-10">
        <!-- Main Content Area -->
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-semibold">Edit Vehicle</h2>
                <a href="{{ route('admin.vehicle.list') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Back</a>
            </div>

            @include('layouts.message')

            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('admin.vehicle.update', $vehicle->id) }}" method="POST" id="vehicleForm" name="vehicleForm"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Registration Number -->
                        <div>
                            <label for="registration_number" class="form-label block text-gray-700 font-medium mb-1">Registration Number</label>
                            <input
                                type="text"
                                id="registration_number"
                                name="registration_number"
                                value="{{ old('registration_number', $vehicle->registration_number) }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('registration_number') is-invalid @enderror"
                                placeholder="Registration Number">
                            @error('registration_number')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Model -->
                        <div>
                            <label for="model" class="form-label block text-gray-700 font-medium mb-1">Model</label>
                            <input
                                type="text"
                                id="model"
                                name="model"
                                value="{{ old('model', $vehicle->model) }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('model') is-invalid @enderror"
                                placeholder="Vehicle Model">
                            @error('model')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacity -->
                        <div>
                            <label for="capacity" class="form-label block text-gray-700 font-medium mb-1">Capacity</label>
                            <input
                                type="number"
                                step="0.01"
                                id="capacity"
                                name="capacity"
                                value="{{ old('capacity', $vehicle->capacity) }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('capacity') is-invalid @enderror"
                                placeholder="Passenger Capacity">
                            @error('capacity')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amenities -->
                        <div>
                            <label for="amenities" class="form-label block text-gray-700 font-medium mb-1">Amenities</label>
                            <textarea
                                id="amenities"
                                name="amenities"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('amenities') is-invalid @enderror"
                                placeholder="List amenities (e.g., Wi-Fi, AC, Recliner Seats)">{{ old('amenities', $vehicle->amenities) }}</textarea>
                            @error('amenities')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Vehicle Picture Upload -->
                        {{-- <div>
                            <label for="vehicle_picture" class="form-label block text-gray-700 font-medium mb-1">Vehicle Picture</label>
                            <div class="relative">
                                <div
                                    class="form-control border-2 border-dashed border-blue-400 rounded p-6 text-center text-gray-500 cursor-pointer relative">
                                    @if($vehicle->vehicle_picture)
                                        <img id="vehiclePreview" src="{{ asset('Uploads/vehicle_pictures/thumb/' . $vehicle->vehicle_picture) }}" alt="Preview"
                                            class="mx-auto w-32 h-32 object-contain mb-2 rounded border border-gray-300" />
                                        <span id="vehiclePlaceholder" class="hidden">Drop files here or click to upload.</span>
                                    @else
                                        <img id="vehiclePreview" src="#" alt="Preview"
                                            class="mx-auto hidden w-32 h-32 object-contain mb-2 rounded border border-gray-300" />
                                        <span id="vehiclePlaceholder">Drop files here or click to upload.</span>
                                    @endif

                                    <input type="file" id="vehicle_picture" name="vehicle_picture"
                                        class="absolute inset-0 opacity-0 cursor-pointer @error('vehicle_picture') is-invalid @enderror"
                                        onchange="previewImage(event, 'vehiclePreview', 'vehiclePlaceholder', 'deleteVehicleBtn', 'delete_vehicle_picture')">

                                    @error('vehicle_picture')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if($vehicle->vehicle_picture)
                                <button type="button" id="deleteVehicleBtn"
                                    onclick="deleteImage('vehicle_picture', 'vehiclePreview', 'vehiclePlaceholder', 'deleteVehicleBtn', 'delete_vehicle_picture')"
                                    class="absolute top-0 right-0 mt-2 mr-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                @else
                                <button type="button" id="deleteVehicleBtn"
                                    onclick="deleteImage('vehicle_picture', 'vehiclePreview', 'vehiclePlaceholder', 'deleteVehicleBtn', 'delete_vehicle_picture')"
                                    class="hidden absolute top-0 right-0 mt-2 mr-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                @endif

                                <input type="hidden" id="delete_vehicle_picture" name="delete_vehicle_picture" value="0">
                            </div>
                        </div> --}}

                        <!-- Is Active -->
                        <div>
                            <label for="is_active" class="form-label block text-gray-700 font-medium mb-1">Is Active</label>
                            <select
                                name="is_active"
                                id="is_active"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active', $vehicle->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $vehicle->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center space-x-4 pt-4">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition">Update</button>
                        <a href="{{ route('admin.vehicle.list') }}"
                            class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
{{-- 
@push('scripts')
    <script>
        function previewImage(event, previewId, placeholderId, deleteBtnId, deleteInputId) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const deleteBtn = document.getElementById(deleteBtnId);
            const deleteInput = document.getElementById(deleteInputId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    deleteBtn.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    deleteInput.value = '0'; // Reset delete flag if new image is selected
                };
                reader.readAsDataURL(file);
            }
        }

        function deleteImage(inputId, previewId, placeholderId, deleteBtnId, deleteInputId) {
            const imageInput = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const deleteBtn = document.getElementById(deleteBtnId);
            const deleteInput = document.getElementById(deleteInputId);

            preview.src = '#';
            preview.classList.add('hidden');
            deleteBtn.classList.add('hidden');
            placeholder.classList.remove('hidden');

            imageInput.value = "";
            deleteInput.value = '1';
        }
    </script>
@endpush --}}
@extends('layouts.admin')

@section('page-title', 'Route')

@section('main')
    <div class="overflow-y-auto h-screen pb-10">
        <!-- Main Content Area -->
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-semibold">Edit Route</h2>
                <a href="{{ route('admin.route.list') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Back</a>
            </div>

            @include('layouts.message')

            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('admin.route.update', $route->id) }}" method="POST" id="routeForm" name="routeForm"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Origin -->
                        <div>
                            <label for="origin" class="form-label block text-gray-700 font-medium mb-1">Origin</label>
                            <input type="text" id="origin" name="origin" value="{{ old('origin', $route->origin) }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('origin') is-invalid @enderror"
                                placeholder="Origin City">
                            @error('origin')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Destination -->
                        <div>
                            <label for="destination" class="form-label block text-gray-700 font-medium mb-1">Destination</label>
                            <input type="text" id="destination" name="destination" value="{{ old('destination', $route->destination) }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('destination') is-invalid @enderror"
                                placeholder="Destination City">
                            @error('destination')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Distance -->
                        <div>
                            <label for="distance" class="form-label block text-gray-700 font-medium mb-1">Distance (km)</label>
                            <input type="number" id="distance" name="distance" value="{{ old('distance', $route->distance) }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('distance') is-invalid @enderror"
                                placeholder="Distance in kilometers">
                            @error('distance')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Departure Time -->
                        <div>
                            <label for="departure_time" class="form-label block text-gray-700 font-medium mb-1">Departure Time</label>
                            <input type="time" id="departure_time" name="departure_time" value="{{ old('departure_time', $route->departure_time) }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('departure_time') is-invalid @enderror">
                            @error('departure_time')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Arrival Time -->
                        <div>
                            <label for="arrival_time" class="form-label block text-gray-700 font-medium mb-1">Arrival Time</label>
                            <input type="time" id="arrival_time" name="arrival_time" value="{{ old('arrival_time', $route->arrival_time) }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('arrival_time') is-invalid @enderror">
                            @error('arrival_time')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-gray-700 font-medium mb-1">Status</label>
                            <select name="status" id="status" class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                <option value="1" {{ old('status', $route->status) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $route->status) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center space-x-4 pt-4">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition">Update</button>
                        <a href="{{ route('admin.route.list') }}"
                            class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

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
@endpush
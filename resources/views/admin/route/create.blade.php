@extends('layouts.admin')

@section('page-title', 'Routes')

@section('main')
<div class="overflow-y-auto h-screen pb-10">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold">Create Route</h2>
            <a href="{{ route('admin.route.list') }}"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Back</a>
        </div>

        @include('layouts.message')

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.route.store') }}" method="POST" id="routeForm" name="routeForm" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Origin -->
                    <div>
                        <label for="origin" class="form-label block text-gray-700 font-medium mb-1">Origin</label>
                        <input type="text" id="origin" name="origin" value="{{ old('origin') }}"
                            class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('origin') is-invalid @enderror"
                            placeholder="Origin City">
                        @error('origin')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Destination -->
                    <div>
                        <label for="destination" class="form-label block text-gray-700 font-medium mb-1">Destination</label>
                        <input type="text" id="destination" name="destination" value="{{ old('destination') }}"
                            class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('destination') is-invalid @enderror"
                            placeholder="Destination City">
                        @error('destination')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Distance -->
                    <div>
                        <label for="distance" class="form-label block text-gray-700 font-medium mb-1">Distance (km)</label>
                        <input type="number" id="distance" name="distance" value="{{ old('distance') }}"
                            class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('distance') is-invalid @enderror"
                            placeholder="e.g. 320">
                        @error('distance')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Departure Time -->
                    <div>
                        <label for="departure_time" class="form-label block text-gray-700 font-medium mb-1">Departure Time</label>
                        <input type="time" id="departure_time" name="departure_time" value="{{ old('departure_time') }}"
                            class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('departure_time') is-invalid @enderror">
                        @error('departure_time')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Arrival Time -->
                    <div>
                        <label for="arrival_time" class="form-label block text-gray-700 font-medium mb-1">Arrival Time</label>
                        <input type="time" id="arrival_time" name="arrival_time" value="{{ old('arrival_time') }}"
                            class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('arrival_time') is-invalid @enderror">
                        @error('arrival_time')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-gray-700 font-medium mb-1">Status</label>
                        <select name="status" id="status" class="w-full border rounded px-4 py-2">
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center space-x-4 pt-4">
                    <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded shadow hover:bg-green-700 transition">Create</button>
                    <a href="{{ route('admin.route.list') }}"
                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

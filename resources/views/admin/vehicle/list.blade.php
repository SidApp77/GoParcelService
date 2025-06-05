@extends('layouts.admin')

@section('page-title', 'Vehicle')

@section('main')
<div class="overflow-y-auto h-screen pb-10">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold">Vehicles</h2>
            <a href="{{ route('admin.vehicle.create') }}"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">New Vehicle</a>
        </div>

        @include('layouts.message')

        <div class="bg-white shadow-md rounded-lg p-4">
            <!-- Filter + Search -->
            <div class="flex justify-between items-center mb-4">
                <a href="{{ url()->current() }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">Reset</a>

                <form action="#" method="GET" class="flex items-center border rounded overflow-hidden">
                    <input type="text" name="search" placeholder="Search" value="{{ request('search') }}"
                        class="px-4 py-2 focus:outline-none" />
                    <button type="submit" class="bg-gray-200 px-4 py-2 hover:bg-gray-300">
                        <i class="fas fa-search text-gray-600"></i>
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-t">
                    <thead class="bg-green-100 text-left">
                        <tr>
                            <th class="px-4 py-2 font-semibold">ID</th>
                            <th class="px-4 py-2 font-semibold">Registration No.</th>
                            <th class="px-4 py-2 font-semibold">Model</th>
                            <th class="px-4 py-2 font-semibold">Capacity</th>
                            <th class="px-4 py-2 font-semibold">Amenities</th>
                            <th class="px-4 py-2 font-semibold">Status</th>
                            <th class="px-4 py-2 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($vehicles as $vehicle)
                            <tr>
                                <td class="px-4 py-2">{{ $vehicle->id }}</td>
                                <td class="px-4 py-2">{{ $vehicle->registration_number }}</td>
                                <td class="px-4 py-2">{{ $vehicle->model }}</td>
                                <td class="px-4 py-2">{{ $vehicle->capacity }}</td>
                                <td class="px-4 py-2">{{ $vehicle->amenities ?? 'N/A' }}</td>
                                <td class="px-4 py-2">
                                    @if ($vehicle->is_active)
                                        <span class="text-green-500 text-xl"><i class="fas fa-check-circle"></i></span>
                                    @else
                                        <span class="text-red-500 text-xl"><i class="fas fa-times-circle"></i></span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 space-x-3">
                                    <a href="{{ route('admin.vehicle.edit', $vehicle->id) }}"
                                       class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></a>
                                    <a href="javascript:void(0);" onclick="openDeleteModal({{ $vehicle->id }})"
                                       class="text-red-500 hover:text-red-700">
                                       <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No vehicles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $vehicles->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div
            style="background:white; padding:20px; border-radius:10px; width:90%; max-width:400px; text-align:center;">
            <h3 style="font-size:20px; margin-bottom:20px;">Confirm Delete</h3>
            <p>Are you sure you want to delete this vehicle?</p>
            <div style="margin-top:20px;">
                <button onclick="closeDeleteModal()"
                        style="padding:8px 16px; margin-right:10px; background-color:#ccc; border:none; border-radius:5px;">Cancel</button>
                <button onclick="confirmDelete()"
                        style="padding:8px 16px; background-color:#e3342f; color:white; border:none; border-radius:5px;">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let vehicleToDeleteId = null;

    function openDeleteModal(id) {
        vehicleToDeleteId = id;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        vehicleToDeleteId = null;
        document.getElementById('deleteModal').style.display = 'none';
    }

    function confirmDelete() {
        if (!vehicleToDeleteId) return;

        fetch("{{ url('/admin/vehicle/delete') }}/" + vehicleToDeleteId, {
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                closeDeleteModal();
                if (data.status) {
                    location.reload();
                } else {
                    alert(data.message || 'Failed to delete vehicle.');
                }
            })
            .catch(error => {
                closeDeleteModal();
                console.error('Error:', error);
                alert('Something went wrong.');
            });
    }
</script>
@endsection

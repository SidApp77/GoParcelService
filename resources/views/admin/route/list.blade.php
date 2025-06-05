@extends('layouts.admin')

@section('page-title', 'Route')

@section('main')
<div class="overflow-y-auto h-screen pb-10">
    <!-- Main Content Area -->
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold">Routes</h2>
            <a href="{{ route('admin.route.create') }}"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Add New Route</a>
        </div>

        @include('layouts.message')

        <div class="bg-white shadow-md rounded-lg p-4">
            <!-- Filter + Search -->
            <div class="flex justify-between items-center mb-4">
                <a href="{{ url()->current() }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">Reset</a>

                <form action="{{ route('admin.route.list') }}" method="GET"
                    class="flex items-center border rounded overflow-hidden">
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
                            <th class="px-4 py-2 font-semibold">Origin</th>
                            <th class="px-4 py-2 font-semibold">Destination</th>
                            <th class="px-4 py-2 font-semibold">Distance (km)</th>
                            <th class="px-4 py-2 font-semibold">Departure Time</th>
                            <th class="px-4 py-2 font-semibold">Arrival Time</th>
                            <th class="px-4 py-2 font-semibold">Status</th>
                            <th class="px-4 py-2 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($routes ?? [] as $route)
                            <tr>
                                <td class="px-4 py-2">{{ $route->id }}</td>
                                <td class="px-4 py-2">{{ $route->origin }}</td>
                                <td class="px-4 py-2">{{ $route->destination }}</td>
                                <td class="px-4 py-2">{{ $route->distance }}</td>
                                <td class="px-4 py-2">{{ $route->departure_time }}</td>
                                <td class="px-4 py-2">{{ $route->arrival_time }}</td>
                                <td class="px-4 py-2">
                                    @if ($route->status)
                                        <span class="text-green-500 text-xl"><i class="fas fa-check-circle"></i></span>
                                    @else
                                        <span class="text-red-500 text-xl"><i class="fas fa-times-circle"></i></span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 space-x-3">
                                    <a href="{{ route('admin.route.edit', $route->id) }}" 
                                       class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></a>
                                    <a href="javascript:void(0);" onclick="openDeleteModal({{ $route->id }})"
                                       class="text-red-500 hover:text-red-700"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">No routes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Delete Confirmation Modal -->
                <div id="deleteModal"
                    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
                    <div
                        style="background:white; padding:20px; border-radius:10px; width:90%; max-width:400px; text-align:center;">
                        <h3 style="font-size:20px; margin-bottom:20px;">Confirm Delete</h3>
                        <p>Are you sure you want to delete this route?</p>
                        <div style="margin-top:20px;">
                            <button onclick="closeDeleteModal()"
                                style="padding:8px 16px; margin-right:10px; background-color:#ccc; border:none; border-radius:5px;">Cancel</button>
                            <button onclick="confirmDelete()"
                                style="padding:8px 16px; background-color:#e3342f; color:white; border:none; border-radius:5px;">Delete</button>
                        </div>
                    </div>
                </div>

                {{-- Pagination --}}
                @if (!empty($routes))
                    <div class="mt-4">
                        {{ $routes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let routeToDeleteId = null;

    function openDeleteModal(id) {
        routeToDeleteId = id;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        routeToDeleteId = null;
        document.getElementById('deleteModal').style.display = 'none';
    }

    function confirmDelete() {
        if (!routeToDeleteId) return;

        fetch("{{ url('/admin/route/delete') }}/" + routeToDeleteId, {
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
                    alert(data.message || 'Failed to delete route.');
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
@extends('layouts.admin')

@section('page-title', 'Staff')

@section('main')
    <div class="overflow-y-auto h-screen pb-10">
        <!-- Main Content Area -->
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-semibold">Staff</h2>
                <a href="{{ route('admin.staff.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">New Staff</a>
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
                                <th class="px-4 py-2 font-semibold">Name</th>
                                <th class="px-4 py-2 font-semibold">Email</th>
                                <th class="px-4 py-2 font-semibold">Phone</th>
                                <th class="px-4 py-2 font-semibold">Role</th>
                                <th class="px-4 py-2 font-semibold">Status</th>
                                <th class="px-4 py-2 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            {{-- Replace with actual $staff data --}}
                            @forelse ($staffs as $member)
                                <tr>
                                    <td class="px-4 py-2">{{ $member->id }}</td>
                                    <td class="px-4 py-2">{{ $member->name }}</td>
                                    <td class="px-4 py-2">{{ $member->email }}</td>
                                    <td class="px-4 py-2">{{ $member->phone ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $member->role }}</td>
                                    <td class="px-4 py-2">
                                        @if ($member->is_active)
                                            <span class="text-green-500 text-xl"><i class="fas fa-check-circle"></i></span>
                                        @else
                                            <span class="text-red-500 text-xl"><i class="fas fa-times-circle"></i></span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 space-x-3">
                                        <a href="{{ route('admin.staff.edit', $member->id) }}"
                                            class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0);" onclick="openDeleteModal({{ $member->id }})"
                                            class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No staff found.</td>
                                </tr>
                            @endforelse

                            {{-- Pagination --}}
                            @if (!empty($staffs))
                                <div class="mt-4">
                                    {{ $staffs->links() }}
                                </div>
                            @endif

                            <!-- Delete Confirmation Modal -->
                            <div id="deleteModal"
                                style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
                                <div
                                    style="background:white; padding:20px; border-radius:10px; width:90%; max-width:400px; text-align:center;">
                                    <h3 style="font-size:20px; margin-bottom:20px;">Confirm Delete</h3>
                                    <p>Are you sure you want to delete this staff member?</p>
                                    <div style="margin-top:20px;">
                                        <button onclick="closeDeleteModal()"
                                            style="padding:8px 16px; margin-right:10px; background-color:#ccc; border:none; border-radius:5px;">Cancel</button>
                                        <button onclick="confirmDelete()"
                                            style="padding:8px 16px; background-color:#e3342f; color:white; border:none; border-radius:5px;">Delete</button>
                                    </div>
                                </div>
                            </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let staffToDeleteId = null;

        function openDeleteModal(id) {
            staffToDeleteId = id;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            staffToDeleteId = null;
            document.getElementById('deleteModal').style.display = 'none';
        }

        function confirmDelete() {
            if (!staffToDeleteId) return;

            fetch("{{ url('/admin/staff/delete') }}/" + staffToDeleteId, {
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
                        alert(data.message || 'Failed to delete staff.');
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
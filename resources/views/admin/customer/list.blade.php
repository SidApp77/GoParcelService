@extends('layouts.admin')

@section('page-title', 'Customer')

@section('main')
<div class="overflow-y-auto h-screen pb-10">
    <!-- Main Content Area -->
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold">Customers</h2>
            <a href="#"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">New Customer</a>
        </div>

        @include('layouts.message')

        <div class="bg-white shadow-md rounded-lg p-4">
            <!-- Filter + Search -->
            <div class="flex justify-between items-center mb-4">
                <a href="#"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">Reset</a>

                <form action="#" method="GET"
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
                            <th class="px-4 py-2 font-semibold">Name</th>
                            <th class="px-4 py-2 font-semibold">Email</th>
                            <th class="px-4 py-2 font-semibold">Phone</th>
                            <th class="px-4 py-2 font-semibold">City</th>
                            <th class="px-4 py-2 font-semibold">Status</th>
                            <th class="px-4 py-2 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($customers ?? [] as $customer)
                            <tr>
                                <td class="px-4 py-2">{{ $customer->id }}</td>
                                <td class="px-4 py-2">{{ $customer->name }}</td>
                                <td class="px-4 py-2">{{ $customer->email }}</td>
                                <td class="px-4 py-2">{{ $customer->phone ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $customer->city ?? 'N/A' }}</td>
                                <td class="px-4 py-2">
                                    @if ($customer->status)
                                        <span class="text-green-500 text-xl"><i class="fas fa-check-circle"></i></span>
                                    @else
                                        <span class="text-red-500 text-xl"><i class="fas fa-times-circle"></i></span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 space-x-3">
                                    <a href="#" class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></a>
                                    <a href="#" onclick="deleteCustomer({{ $customer->id }})"
                                       class="text-red-500 hover:text-red-700"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination Placeholder --}}
                @if (!empty($customers))
                    <div class="mt-4">
                        {{-- {{ $customers->links() }} --}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function deleteCustomer(id) {
        if (confirm('Are you sure you want to delete this customer?')) {
            // Replace with real AJAX call or form submission
            alert("Customer with ID " + id + " deleted (simulated).");
        }
    }
</script>
@endsection

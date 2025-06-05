@extends('layouts.admin')

@section('page-title', 'Staff')

@section('main')
    <div class="overflow-y-auto h-screen pb-10">
        <!-- Main Content Area -->
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-semibold">Create Staff</h2>
                <a href="{{ route('admin.staff.list') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Back</a>
            </div>

            @include('layouts.message')

            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('admin.staff.store') }}" method="POST" id="staffForm" name="staffForm"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="form-label block text-gray-700 font-medium mb-1">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('name') is-invalid @enderror"
                                placeholder="Full Name">
                            @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="form-label block text-gray-700 font-medium mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('email') is-invalid @enderror"
                                placeholder="Email Address">
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="form-label block text-gray-700 font-medium mb-1">Password</label>
                            <input type="password" id="password" name="password"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('password') is-invalid @enderror"
                                placeholder="Password">
                            @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="form-label block text-gray-700 font-medium mb-1">Phone</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('phone') is-invalid @enderror"
                                placeholder="Phone Number">
                            @error('phone')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-gray-700 font-medium mb-1">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('role')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Profile Picture Upload -->
                        <div>
                            <label for="profile_picture" class="form-label block text-gray-700 font-medium mb-1">Profile
                                Picture</label>
                            <div class="relative">
                                <div
                                    class="form-control border-2 border-dashed border-blue-400 rounded p-6 text-center text-gray-500 cursor-pointer relative">
                                    <img id="profilePreview" src="#" alt="Preview"
                                        class="mx-auto hidden w-32 h-32 object-contain mb-2 rounded border border-gray-300" />

                                    <input type="file" id="profile_picture" name="profile_picture"
                                        class="absolute inset-0 opacity-0 cursor-pointer @error('profile_picture') is-invalid @enderror"
                                        onchange="previewImage(event, 'profilePreview', 'profilePlaceholder', 'deleteProfileBtn', 'delete_profile_picture')">

                                    @error('profile_picture')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror

                                    <span id="profilePlaceholder">Drop files here or click to upload.</span>
                                </div>

                                <button type="button" id="deleteProfileBtn"
                                    onclick="deleteImage('profile_picture', 'profilePreview', 'profilePlaceholder', 'deleteProfileBtn', 'delete_profile_picture')"
                                    class="hidden absolute top-0 right-0 mt-2 mr-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <input type="hidden" id="delete_profile_picture" name="delete_profile_picture" value="0">
                            </div>
                        </div>

                        <!-- ID Proof Upload -->
                        <div>
                            <label for="id_proof" class="form-label block text-gray-700 font-medium mb-1">ID Proof</label>
                            <div class="relative">
                                <div
                                    class="form-control border-2 border-dashed border-blue-400 rounded p-6 text-center text-gray-500 cursor-pointer relative">
                                    <img id="idProofPreview" src="#" alt="Preview"
                                        class="mx-auto hidden w-32 h-32 object-contain mb-2 rounded border border-gray-300" />

                                    <input type="file" id="id_proof" name="id_proof"
                                        class="absolute inset-0 opacity-0 cursor-pointer @error('id_proof') is-invalid @enderror"
                                        onchange="previewImage(event, 'idProofPreview', 'idProofPlaceholder', 'deleteIdProofBtn', 'delete_id_proof')">

                                    @error('id_proof')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror

                                    <span id="idProofPlaceholder">Drop files here or click to upload.</span>
                                </div>

                                <button type="button" id="deleteIdProofBtn"
                                    onclick="deleteImage('id_proof', 'idProofPreview', 'idProofPlaceholder', 'deleteIdProofBtn', 'delete_id_proof')"
                                    class="hidden absolute top-0 right-0 mt-2 mr-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <input type="hidden" id="delete_id_proof" name="delete_id_proof" value="0">
                            </div>
                        </div>

                        <!-- ID Number -->
                        <div>
                            <label for="id_number" class="form-label block text-gray-700 font-medium mb-1">ID Number</label>
                            <input type="text" id="id_number" name="id_number" value="{{ old('id_number') }}"
                                class="form-control w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('id_number') is-invalid @enderror"
                                placeholder="ID Number">
                            @error('id_number')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Active -->
                        <div>
                            <label for="is_active" class="block text-gray-700 font-medium mb-1">Is Active</label>
                            <select name="is_active" id="is_active" class="w-full border rounded px-4 py-2">
                                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center space-x-4 pt-4">
                        <button type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded shadow hover:bg-green-700 transition">Create</button>
                        <a href="{{ route('admin.staff.list') }}"
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
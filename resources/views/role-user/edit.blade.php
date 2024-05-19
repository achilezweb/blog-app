<!-- roleUsers/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('role-user.index') }}">{{ __('RoleUsers') }}</a> | {{ __('Edit Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Display success message -->
            @if (session('success'))
            <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-1-9V8a1 1 0 1 1 2 0v3a1 1 0 1 1-2 0zm0 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0z"/></svg></div>
                    <div>
                        <p class="font-bold text-white">Success</p>
                        <p class="text-sm text-white">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Display error message -->
            @if (session('error'))
            <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-1-9V8a1 1 0 1 1 2 0v3a1 1 0 1 1-2 0zm0 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0z"/></svg></div>
                    <div>
                        <p class="font-bold text-red-900">Error</p>
                        <p class="text-sm text-red-900">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <h1 class="text-xl font-semibold">Edit Roles for {{ $user->name }}</h1>
                    <form method="POST" action="{{ route('role-user.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div>
                            <select name="role_id[]" id="role_id" class="form-control block w-full mt-1" multiple>
                                @foreach($roles as $role)
                                    @if ((auth()->user()->hasRoles('admin') && $role->name !== 'superadmin') || auth()->user()->hasRoles('superadmin'))
                                        <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('role_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button type="submit">Update</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


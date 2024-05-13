<!-- roleUsers/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('roleUsers.index') }}">{{ __('RoleUsers') }}</a> | {{ __('Edit Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <h1 class="text-xl font-semibold">Edit Roles for {{ $user->name }}</h1>
                    <form method="POST" action="{{ route('roleUsers.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div>
                            <select name="role_id[]" id="role_id" class="form-control block w-full mt-1" multiple>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
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


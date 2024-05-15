<!-- roleUsers/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('role-users.index') }}">{{ __('RoleUsers') }}</a> | {{ __('Show Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    <h1 class="text-xl font-semibold">{{ $roleUser->name }}'s Roles</h1>
                    <h2>{{ $roleUser->email }}</h2>
                    <ul>
                        @foreach($roleUser->roles as $role)
                            <li>{{ $role->name }}</li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>


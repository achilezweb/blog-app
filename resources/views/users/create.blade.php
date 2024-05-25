<!-- users/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('users.index') }}">{{ __('Users') }}</a> | {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div>
                            <input type="text" name="name" id="name" class="block mt-1 w-full" placeholder="Enter Name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <input type="password" name="password" id="password" class="block mt-1 w-full" placeholder="Enter Password" >
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <input type="text" name="email" id="email" class="block mt-1 w-full" placeholder="Enter Email" value="{{ old('email') }}" required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button type="submit">Create</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- users/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('users.index') }}">{{ __('Users') }}</a> | {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <input type="text" name="name" id="name" class="block mt-1 w-full" placeholder="Enter Name" value="{{ old('name') ?? $user->name }}" required autofocus>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <input type="password" name="password" id="password" class="block mt-1 w-full" placeholder="Enter Password" value="">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <input type="text" name="email" id="email" class="block mt-1 w-full" placeholder="Enter Email" value="{{ old('email') ?? $user->email }}" required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <input type="text" name="username" id="username" class="block mt-1 w-full" placeholder="Enter Username" value="{{ old('username') ?? $user->username }}" >
                            @error('username')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <input type="text" name="photo" id="photo" class="block mt-1 w-full" placeholder="Enter Photo" value="{{ old('photo') ?? $user->photo }}" >
                            @error('photo')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <input type="text" name="active" id="active" class="block mt-1 w-full" placeholder="Active?" value="{{ old('active') ?? $user->active }}" >
                            @error('active')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <input type="text" name="archive" id="archive" class="block mt-1 w-full" placeholder="Archived?" value="{{ old('archive') ?? $user->archive }}" >
                            @error('archive')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <input type="text" name="email_verified_at" id="email_verified_at" class="block mt-1 w-full" placeholder="Email Verified at?" value="{{ old('email_verified_at') ?? $user->email_verified_at }}" >
                            @error('email_verified_at')
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

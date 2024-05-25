<!-- users/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('users.index') }}">{{ __('Users') }}</a> | {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Username</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->username }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Photo</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="User Profile Photo" width="100">
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Active</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->active }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Archive</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->archive }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Email Verified At</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email_verified_at }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">QR Code</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->qrCode }}</dd> {{-- Generated from user model --}}
                            <hr>
                            <div>
                                <img src="{{ asset('storage/' . $user->qrcodes) }}" alt="User QR Code" width="300"> {{-- Saved in storage --}}
                                <br>
                                <img src="data:image/png;base64,{{ $user->barcode }}" alt="User Barcode">
                            </div>
                        </div>
                        <!-- Add additional fields as needed -->
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

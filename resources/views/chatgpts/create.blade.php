<!-- categories/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('chatgpts.index') }}">{{ __('Chatgpts') }}</a> | {{ __('Create Chatgpt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('chatgpts.store') }}">
                        @csrf

                        <div>
                            <textarea name="prompt" id="prompt" class="block mt-1 w-full" rows="4" placeholder="Enter Question" required autofocus>{{ old('name') }}</textarea>
                            @error('prompt')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button type="submit">Submit</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

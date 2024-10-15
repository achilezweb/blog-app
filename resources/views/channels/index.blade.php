<!-- chatgpts/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('chatgpts.index') }}">{{ __('Chatgpts') }}</a> |
            <a href="{{ route('channels.index') }}">{{ __('Channels') }}</a> |
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

            <div class="py-4">
                <form action="{{ route('channels.search') }}" method="GET">
                    <input type="text" name="query" id="query" placeholder="Search..." value="{{ old('query') }}" required>
                    @error('query')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <x-primary-button type="submit">Search</x-primary-button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('channels.store') }}">
                        @csrf

                        <div>
                            <input type="text" name="name" id="name" class="block mt-1 w-full" rows="4" placeholder="Enter New Channel" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button type="submit">Submit</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="py-2"></div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                User ID
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                Channel Name
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                Edit
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                Delete
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($channels as $channel)
                            <tr>
                                <td class="px-6 py-4 whitespace-wrap">
                                    {{ $channel->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-wrap">
                                    {{ $channel->user_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-wrap">
                                    {{ $channel->name }}
                                </td>                                
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('channels.edit', $channel) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('channels.destroy', $channel) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-xl font-semibold block text-white">
                Pagination: {{ $channels->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

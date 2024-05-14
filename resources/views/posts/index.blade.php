<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('posts.index') }}">{{ __('Posts') }}</a>
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold block text-white">Search:</h1>

        <form action="{{ route('posts.search') }}" method="GET">
            <input type="text" name="query" id="query" placeholder="Search..." required>
            @error('query')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <x-primary-button type="submit">Seach</x-primary-button>
        </form>

        <h1 class="text-2xl font-semibold block text-white py-6">Posts:</h1>

        @auth
            <form action="{{ route('posts.store') }}" method="POST">
                @csrf
                <input type="text"name="title" id="title" class="w-full" placeholder="Enter Title" required autofocus>
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <textarea name="body" id="body" cols="30" rows="5" class="w-full" placeholder="Enter Description" required></textarea>
                @error('body')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <input type="hidden" name="category_id" id="category_id" value="1">
                <input type="hidden" name="tag_id" id="tag_id" value="1">
                <input type="hidden" name="privacy_id" id="privacy_id" value="1">
                <x-primary-button type="submit">Add Post</x-primary-button>
            </form>
        @endauth

        <ul class="divide-y">
            @foreach($posts as $post)
                <li class="py-4 px-2">
                    <a href="{{  route('posts.show', $post) }}" class="text-xl font-semibold block text-white">{{ $post->id }} {{ $post->title }}</a>
                    <p class="text-sm text-gray-400">{{ $post->body }}</p>
                    <span class="text-sm text-gray-600">
                        Category ID: xxx | Category Name: yyy |
                        Date: {{ $post->created_at }} | {{ $post->created_at->diffForHumans() }} by <strong>{{ $post->user->name }}</strong>
                    </span>

                    @can('delete', $post)
                        <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">Delete Post</x-danger-button>
                        </form>
                    @endcan
                    @can('update', $post)
                        <a href="{{  route('posts.edit', $post) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Edit Post</a>
                    @endcan
                </li>
            @endforeach
        </ul>

        <div class="text-xl font-semibold block text-white">
            Pagination: {{ $posts->links() }}
        </div>

    </div>
</x-app-layout>

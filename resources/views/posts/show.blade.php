<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('posts.index') }}">{{ __('Posts') }}</a> - {{ __('Show') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold block text-white">Posts:</h1>

        <div class="text-xl font-semibold block text-white">{{ $post->id }} {{ $post->title }}</div>
        <span class="text-sm text-gray-600">
            Category ID: xxx | Category Name: yyy |
            Date: {{ $post->created_at }} | {{ $post->created_at->diffForHumans() }} | Posted by {{ $post->user->name }}
        </span>
        <p class="text-sm text-gray-400">{{ $post->body }}</p>

        <h2 id="comments" class="font-semibold text-xl text-white leading-tight py-6">Comments:</h2>

        @auth
            <form action="{{ route('posts.comments.store', $post) }}" method="POST">
                @csrf
                <textarea name="body" id="body" cols="30" rows="5" class="w-full" placeholder="Enter Comment" required></textarea>
                @error('body')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <x-primary-button type="submit">Add Comment</x-primary-button>

            </form>
        @endauth

        <ul class="divide-y">
            @foreach($comments as $comment)
                <li class="py-4 px-2">
                    <p class="text-sm text-gray-400">{{ $comment->id }} {{ $comment->body }}</p>
                    <span class="text-sm text-gray-600">{{ $comment->created_at->diffForHumans() }} by: {{ $comment->user->name }} </span>

                    @can('delete', $comment)
                        <form action="{{ route('posts.comments.destroy', ['post' => $post, 'comment' => $comment]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">Delete Comment</x-danger-button>
                        </form>
                    @endcan

                    @can('update', $comment)
                        <a href="{{ route('posts.comments.edit', ['post' => $post, 'comment' => $comment]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Edit Comment</a>
                    @endcan
                </li>
            @endforeach
        </ul>

        <div class="mt-2">
            {{ $comments->fragment('comments')->links() }}
        </div>





    </div>
</x-app-layout>

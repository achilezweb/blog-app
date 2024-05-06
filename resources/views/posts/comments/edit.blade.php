<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('posts.index') }}">{{ __('Posts') }}</a> - {{ __('Edit Comments') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold block text-white">Comments:</h1>

        @can('update', $comment)
            <form action="{{ route('posts.comments.update', ['post' => $post, 'comment' => $comment]) }}" method="POST">
                @csrf
                @method('PUT')
                <textarea name="body" id="body" cols="30" rows="5" class="w-full" placeholder="Enter Description">{{ $comment->body }}</textarea>
                <x-primary-button type="submit">Update Comment</x-primary-button>
            </form>
        @endcan


    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Show') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold block text-white">Posts:</h1>

        @can('update', $post)
            <form action="{{ route('posts.update', $post) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="text"name="title" id="title" class="w-full" placeholder="Enter Title" value="{{ $post->title }}">
                <textarea name="body" id="body" cols="30" rows="5" class="w-full" placeholder="Enter Description">{{ $post->body }}</textarea>
                {{-- <input type="hidden" name="category_id" id="category_id" value="1">
                <input type="hidden" name="tag_id" id="tag_id" value="1">
                <input type="hidden" name="privacy_id" id="privacy_id" value="1"> --}}
                <x-primary-button type="submit">Update Post</x-primary-button>
            </form>
        @endcan

    </div>
</x-app-layout>

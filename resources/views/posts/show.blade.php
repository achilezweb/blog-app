<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('posts.index') }}">{{ __('Posts') }}</a> - {{ __('Show') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold block text-white">Posts:</h1>

        <div class="text-xl font-semibold block text-white">{{ $post->id }} {{ $post->title }}</div>
        <p class="text-sm text-gray-400">{!! $post->body !!}</p>
        <div class="text-white">QR Codes:
            <img src="{{ asset('storage/' . $post->qrcodes ) }}" alt="User QR Code" width="100"><br>
            <img src="data:image/png;base64,{{ $post->barcode }}" alt="Post Barcode">
        </div>
        <span class="text-sm text-gray-600">
            Date: {{ $post->created_at }} | {{ $post->created_at->diffForHumans() }} | Posted by {{ $post->user->name }} | Privacy: {{ $post->privacy->name }} | Pageviews: {{ $post->page_views }}
        </span>
        <div class="text-sm text-white">
            @auth
                @if(auth()->user()->likedPosts->contains($post->id))
                    <form action="{{ route('posts.unlike', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Unlike</button>
                    </form>
                @else
                    <form action="{{ route('posts.like', $post) }}" method="POST">
                        @csrf
                        <button type="submit">Like</button>
                    </form>
                @endif
            @endauth
            <p>{{ $post->likeCount() }} likes</p>
            <form action="{{ route('posts.share', $post) }}" method="POST">
                @csrf
                <button type="submit">Share</button>
            </form>
            <p>{{ $post->shareCount() }} shares</p>
        </div>
        <p class="text-sm text-gray-400">{!! $post->body !!}</p>
        @if ($post->tags)
            <div class="text-white">Tag:</div>
            <ul>
                @foreach ($post->tags as $tag)
                    <li><div class="text-white">{{ $tag->name }}</div></li>
                @endforeach
            </ul>
        @endif
        @if ($post->categories)
            <div class="text-white">Category:</div>
            <ul>
                @foreach ($post->categories as $category)
                    <li><div class="text-white">{{ $category->name }}</div></li>
                @endforeach
            </ul>
        @endif
        @if($post->location_name)
            <p class="text-white">Location: {{ $post->location_name }} ({{ $post->latitude }}, {{ $post->longitude }})</p>
        @endif
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" style="width:100%;">
        @endif
        <div class="text-white">Multiple Media:</div>
        @foreach ($post->medias as $media)
            <div>
                @if ($media->media_type === 'image')
                    <img src="{{ Storage::url($media->file_path) }}" alt="Post Image">
                @else
                    <video width="320" height="240" controls>
                        <source src="{{ Storage::url($media->file_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>
        @endforeach
        <h2 id="comments" class="font-semibold text-xl text-white leading-tight py-6">Comments:</h2>

        @auth
            <form action="{{ route('posts.comments.store', $post) }}" method="POST">
                @csrf
                <textarea name="body" id="body" cols="30" rows="5" class="w-full" placeholder="Enter Comment" value="{{ old('body') }}" required></textarea>
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

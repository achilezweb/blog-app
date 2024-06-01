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
                <input type="text"name="title" id="title" class="w-full" placeholder="Enter Title" value="{{ old('title') }}" required autofocus>
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <textarea name="body" id="body" cols="30" rows="5" class="w-full" placeholder="Enter Description" required>{{ old('body') }}</textarea>
                @error('body')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                {{-- using tags select dropdown --}}
                {{-- <select name="tags[]" id="tags" class="form-control block w-full mt-1" multiple >
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select> --}}

                {{-- using tags checkbox  --}}
                @foreach ($tags as $tag)
                    <div class="form-check form-check-inline text-white">
                        <input class="form-check-input" type="checkbox" name="tags[]" id="tag_{{ $tag->id }}" value="{{ $tag->id }}"
                            >
                        <label class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                @endforeach

                @error('tags')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- using categories select dropdown --}}
                <select name="categories[]" id="categories" class="form-control block w-full mt-1" multiple >
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                {{-- using categories checkbox  --}}
                {{-- @foreach ($categories as $category)
                    <div class="form-check form-check-inline text-white">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}"
                            >
                        <label class="form-check-label" for="category_{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach --}}

                @error('categories')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- using tagged_users select dropdown --}}
                <select name="tagged_users[]" id="tagged_users" class="form-control block w-full mt-1" multiple >
                    @foreach ($users  as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('tagged_users')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <input type="text" placeholder="Enter Location" id="location_name" name="location_name" value="{{ old('location_name') }}">
                <input type="text" placeholder="Enter Latitude" id="latitude" name="latitude" value="{{ old('latitude') }}">
                <input type="text" placeholder="Enter Longitude" id="longitude" name="longitude" value="{{ old('longitude') }}">

                <select name="privacy_id" id="privacy_id" class="form-control">
                    @foreach(App\Models\Privacy::all() as $privacy)
                        <option value="{{ $privacy->id }}">{{ $privacy->name }}</option>
                    @endforeach
                </select>
                @error('privacy_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <x-primary-button type="submit">Add Post</x-primary-button>
            </form>
        @endauth

        <ul class="divide-y">
            @foreach($posts as $post)
                <li class="py-4 px-2">

                    <a href="{{  route('posts.show', $post) }}" class="text-xl font-semibold block text-white">
                        {{ $post->is_pinned ? 'Pinned:' : '' }} {{ $post->id }} {{ $post->title }}
                    </a>
                    <p class="text-sm text-gray-400">{!! $post->body !!}</p>
                    <div class="text-white">QR Codes:
                        <img src="{{ asset('storage/' . $post->qrcodes ) }}" alt="User QR Code" width="100"><br>
                        <img src="data:image/png;base64,{{ $post->barcode }}" alt="Post Barcode">
                    </div>
                    @if ($post->tags)
                        <div class="text-white">Tags:</div>
                        <ul>
                            @foreach ($post->tags as $tag)
                                <li><div class="text-white">{{ $tag->name }}</div></li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($post->categories)
                        <div class="text-white">Categories:</div>
                        <ul>
                            @foreach ($post->categories as $category)
                                <li><div class="text-white">{{ $category->name }}</div></li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($post->taggedUsers)
                        <div class="text-white">taggedUsers:</div>
                        <ul>
                            @foreach ($post->taggedUsers as $taggedUser)
                                <li><div class="text-white">{{ $taggedUser->name }}</div></li>
                            @endforeach
                        </ul>
                    @endif
                    @if($post->location_name)
                        <p class="text-white">Location: {{ $post->location_name }} ({{ $post->latitude }}, {{ $post->longitude }})</p>
                    @endif
                    <span class="text-sm text-gray-600">
                        Date: {{ $post->created_at }} | {{ $post->created_at->diffForHumans() }} by <strong>{{ $post->user->name }}</strong> | Privacy: {{ $post->privacy->name }} | Pageviews: {{ $post->page_views }}
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
                        @auth
                            <form action="{{ route('posts.share', $post) }}" method="POST">
                                @csrf
                                <button type="submit">Share</button>
                            </form>
                        @endauth
                        <p>{{ $post->shareCount() }} shares</p>
                        @auth
                            @if($post->is_pinned)
                                <form action="{{ route('posts.unpin', $post) }}" method="POST">
                                    @csrf
                                    <button type="submit">Unpin Post</button>
                                </form>
                            @else
                                <form action="{{ route('posts.pin', $post) }}" method="POST">
                                    @csrf
                                    <button type="submit">Pin Post</button>
                                </form>
                            @endif
                        @endauth
                    </div>

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

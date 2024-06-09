<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Show') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold block text-white">Posts:</h1>

        @can('update', $post)
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text"name="title" id="title" class="w-full" placeholder="Enter Title" value="{{ old('title') ?? $post->title }}" required>
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <textarea name="body" id="body" cols="30" rows="5" class="w-full" placeholder="Enter Description" required>{{ old('body') ?? strip_tags($post->body) }}</textarea>
                @error('body')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- using tags select dropdown --}}
                {{-- <select name="tags[]" id="tags" class="form-control block w-full mt-1" multiple >
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id   }}" {{ $post->tags->contains($tag) ? 'selected' : '' }}>{{ $tag->name }}</option>
                    @endforeach
                </select> --}}

                {{-- using tags checkbox  --}}
                @foreach ($tags as $tag)
                    <div class="form-check form-check-inline text-white">
                        <input class="form-check-input" type="checkbox" name="tags[]" id="tag_{{ $tag->id }}" value="{{ $tag->id }}"
                            {{ $post->tags->contains($tag->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                @endforeach
                @error('tags')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- using categories select dropdown --}}
                <select name="categories[]" id="categories" class="form-control block w-full mt-1" multiple >
                    @foreach ($categories as $category)
                        <option value="{{ $category->id   }}" {{ $post->categories->contains($category) ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>

                {{-- using categories checkbox  --}}
                {{-- @foreach ($categories as $category)
                    <div class="form-check form-check-inline text-white">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}"
                            {{ $post->categories->contains($category->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category_{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach --}}

                @error('categories')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- using tagged_users select dropdown --}}
                <select name="tagged_users[]" id="tagged_users" class="form-control block w-full mt-1" multiple >
                    @foreach ($users as $user)
                        <option value="{{ $user->id   }}" {{ $post->taggedUsers->contains($user) ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>

                @error('tagged_users')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <input type="text" placeholder="Enter Location" id="location_name" name="location_name" value="{{ old('location_name') ?? $post->location_name }}">
                <input type="text" placeholder="Enter Latitude" id="latitude" name="latitude" value="{{ old('latitude') ?? $post->latitude }}">
                <input type="text" placeholder="Enter Longitude" id="longitude" name="longitude" value="{{ old('longitude') ?? $post->longitude }}">
                <input type="file" name="image">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" style="width: 100px;">

                <div class="text-white">Multiple Media:</div>
                <input type="file" name="media_files[]" multiple accept="image/*,video/*">
                <h3 class="text-white">Existing Media:</h3>
                @foreach ($post->medias as $media)
                    <div>
                        <input type="checkbox" name="remove_media[]" value="{{ $media->id }}">
                        @if ($media->media_type === 'image')
                            <img src="{{ Storage::url($media->file_path) }}" alt="Post Image" style="width:100px;">
                        @else
                            <video width="160" controls>
                                <source src="{{ Storage::url($media->file_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </div>
                @endforeach

                <select name="privacy_id" id="privacy_id" class="form-control">
                    @foreach(App\Models\Privacy::all() as $privacy)
                        <option value="{{ $privacy->id }}" {{ ($post->privacy_id === $privacy->id) ? 'selected' : '' }}>
                            {{ $privacy->name }}
                    @endforeach
                </select>
                @error('privacy_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <x-primary-button type="submit">Update Post</x-primary-button>
            </form>
        @endcan

    </div>
</x-app-layout>

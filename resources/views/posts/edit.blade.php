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
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <textarea name="body" id="body" cols="30" rows="5" class="w-full" placeholder="Enter Description">{{ $post->body }}</textarea>
                @error('body')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- using tags select dropdown --}}
                {{-- <select name="tags[]" id="tags" class="form-control block w-full mt-1" multiple required>
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
                <select name="categories[]" id="categories" class="form-control block w-full mt-1" multiple required>
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

                <x-primary-button type="submit">Update Post</x-primary-button>
            </form>
        @endcan

    </div>
</x-app-layout>

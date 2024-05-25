{{-- resources/views/posts/deleted.blade.php --}}

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    <a href="{{ route('posts.index') }}">Posts</a> |
                    Deleted Posts
                </h1>
                @if(session('success'))
                    <div class="alert alert-success mt-4">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table-auto w-full mt-6">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Body</th>
                            <th class="px-4 py-2">Deleted At</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td class="border px-4 py-2">{{ $post->title }}</td>
                                <td class="border px-4 py-2">{{ $post->body }}</td>
                                <td class="border px-4 py-2">{{ $post->deleted_at->toFormattedDateString() }}</td>
                                <td class="border px-4 py-2">
                                    <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-gray-800 font-bold py-2 px-4 rounded">Restore</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center border px-4 py-2">No deleted posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

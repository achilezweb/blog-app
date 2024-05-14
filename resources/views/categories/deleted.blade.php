{{-- resources/views/categories/deleted.blade.php --}}

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">Deleted Categories</h1>
                @if(session('success'))
                    <div class="alert alert-success mt-4">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table-auto w-full mt-6">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Deleted At</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="border px-4 py-2">{{ $category->name }}</td>
                                <td class="border px-4 py-2">{{ $category->description }}</td>
                                <td class="border px-4 py-2">{{ $category->deleted_at->toFormattedDateString() }}</td>
                                <td class="border px-4 py-2">
                                    <form action="{{ route('categories.restore', $category->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-gray-800 font-bold py-2 px-4 rounded">Restore</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center border px-4 py-2">No deleted categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

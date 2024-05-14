{{-- resources/views/category-audit-logs/index.blade.php --}}

<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-xl font-semibold">Category Update Audit Logs</h1>

                <div class="mt-6">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Updated By</th>
                                <th class="border px-4 py-2">Category</th>
                                <th class="border px-4 py-2">Action</th>
                                <th class="border px-4 py-2">Changes</th>
                                <th class="border px-4 py-2">Date/Time</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($logs as $log)
                                <tr>
                                    <td class="border px-4 py-2">{{ $log->updater->name }}</td>
                                    <td class="border px-4 py-2">{{ $log->category->name }}</td>
                                    <td class="border px-4 py-2">{{ $log->action }}</td>
                                    <td class="border px-4 py-2">{{ $log->changes }}</td>
                                    <td class="border px-4 py-2">{{ $log->created_at->format('m/d/Y H:i') }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

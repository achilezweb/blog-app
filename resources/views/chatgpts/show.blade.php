<!-- chatgpts/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <a href="{{ route('chatgpts.index') }}">{{ __('Chatgpts') }}</a> |
            <a href="{{ route('channels.index') }}">{{ __('Channels') }}</a> |
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="py-2"></div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prompts/Response
                            </th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-wrap">
                                    <div><a href="{{ route('chatgpts.show', $chatgpt->id) }}">{{ $chatgpt->id }} {{ $chatgpt->prompt }}</a> (Channel: <a href="#">{{ $chatgpt->channel->name }}</a>)</div>
                                    <div class="response-markdown">
                                        {!! Str::markdown($chatgpt->response) !!}
                                    </div>
                                </td>
                                
                            </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-xl font-semibold block text-white">
            </div>

        </div>
    </div>
</x-app-layout>

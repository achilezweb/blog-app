<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name }}'s Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>Username: {{ $user->username }}</p>
                    <hr style="border-color:black;">

                    <h3>Posts</h3>
                    @foreach ($user->posts as $post)
                        <div>
                            <h4>{{ $post->title }}</h4>
                            <p>{{ $post->body }}</p>
                        </div>
                    @endforeach
                    <hr style="border-color:black;">

                    <h3>Friends</h3>
                    @foreach ($user->friends as $friend)
                        <div>{{ $friend->name }}</div>
                    @endforeach
                    <hr style="border-color:black;">

                    <h3>Friend Requests</h3>
                    @foreach ($user->friendRequestsReceived as $request)
                        <div>
                            {{ $request->sender->name }} wants to be your friend.
                            <form action="{{ route('friends.acceptRequest', $request->id) }}" method="POST">
                                @csrf
                                <x-primary-button type="submit">Accept</x-primary-button>
                            </form>
                        </div>
                    @endforeach
                    <hr style="border-color:black;">

                    <h3>Send Friend Request</h3>
                    <form action="{{ route('friends.sendRequest') }}" method="POST">
                        @csrf
                        <input type="hidden" name="username" value="{{ $user->username }}">
                        <x-primary-button type="submit">Send Friend Request</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

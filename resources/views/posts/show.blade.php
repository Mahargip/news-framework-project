<x-app-layout>

    <x-slot name="title">
        {{ $post->title }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Published by {{ $post->writer->name }}, at {{ $post->created_at }}.
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::check() && $post->author == Auth::user()->id)
                <a href="{{ route('post.edit', ['id' => $post->id]) }}" class="bg-blue-100 hover:bg-green-400 text-black text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-white border border-blue-400 inline-flex items-center justify-center">Edit Post</a>
                <a href="{{ route('post.destroy', ['id' => $post->id]) }}" class="bg-blue-100 hover:bg-red-400 text-black text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-white border border-blue-400 inline-flex items-center justify-center">Delete Post</a>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold text-white text-center my-5">{{ $post->title }}</h1>
                    <img class="h-auto max-w-full mx-auto transition-all duration-300 rounded-lg cursor-pointer filter grayscale hover:grayscale-0"
                        src="../../storage/app/image/{{ $post->image }}">
                    <p class="text-gray-400 my-4">{!! nl2br($post->news_content) !!}</p>
                </div>
            </div>
            <br>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-m text-white">{{ $post->comment_total }}</h2>
                    <h2 class="text-xl font-semibold mb-2 text-white">Comments:</h2>
                    {{-- Form tambah komentar --}}
                    <form action="{{ route('comments.store') }}" method="POST" class="mt-4 flex items-center">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <textarea name="comments_content" id="comments_content" rows="3"
                            class="my-8 flex-grow form-input block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Add your comment..."></textarea>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md mx-3">Add</button>
                    </form>

                    @foreach ($post->comments as $comment)
                        <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-3 my-2">
                            <p class="text-gray-900 dark:text-gray-100">{!! nl2br($comment->comments_content) !!}</p>
                            <p class="text-gray-400 text-sm">{{ $comment->commentator->name }}, at
                                {{ $comment->created_at }}.</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

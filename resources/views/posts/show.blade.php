<x-app-layout>

    <x-slot name="title">
        {{ $post->title }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Published by {{ $post->writer->name}}, at {{ $post->created_at }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold text-white text-center my-5">{{ $post->title }}</h1>
                    <img class="h-auto max-w-full mx-auto transition-all duration-300 rounded-lg cursor-pointer filter grayscale hover:grayscale-0" src="../../storage/app/image/{{ $post->image }}">
                    <p class="text-gray-400 my-4">{{ $post->news_content }}</p>
                </div>
            </div>
            <br>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-m text-white">{{ $post->comment_total }}</h2>
                    <h2 class="text-xl font-semibold mb-2 text-white">Comments:</h2>
                    @foreach ($post->comments as $comment)
                        <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-3 my-2">
                            <p class="text-gray-900 dark:text-gray-100">{{ $comment->comments_content }}</p>
                            <p class="text-gray-400 text-sm">{{ $comment->commentator->name }}, at {{ $comment->created_at }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

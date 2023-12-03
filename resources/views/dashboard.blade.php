<x-app-layout>
    <x-slot name="title">
        News
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('News') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- isi dari posts --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-10">
                        @foreach ($posts as $post)
                            <a href="{{ route('post.show', ['id' => $post->id]) }}" class="block">
                                <div class="max-w-sm rounded overflow-hidden shadow-lg">
                                    <img class="w-full h-auto" src="../storage/app/image/{{ $post->image }}" alt="{{ $post->title }}">
                                    <div class="px-6 py-4">
                                        <div class="font-bold text-xl mb-2">{{ $post->title }}</div>
                                        <p class="text-gray-400 text-base">
                                            {{ limit_words($post->news_content, 20) }} . . .
                                        </p>
                                    </div>
                                    <div class="px-6 pt-4 pb-2">
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                            {{ $post->writer->name }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

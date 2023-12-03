<x-app-layout>
    <!-- ... Header dan judul tampilan ... -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('posts.destroy', ['id' => $post->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-semibold text-gray-600 dark:text-gray-200">
                                Title:
                            </label>
                            <input type="text" name="title" id="title" class="form-input block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('title', $post->title) }}" disabled>
                        </div>
                        <div class="mb-4">
                            <label for="news_content" class="block text-sm font-semibold text-gray-600 dark:text-gray-200">
                                Content:
                            </label>
                            <textarea name="news_content" id="news_content" class="form-input block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled rows="10">{{ old('news_content', $post->news_content) }}</textarea>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

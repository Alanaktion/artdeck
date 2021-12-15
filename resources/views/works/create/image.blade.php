<form
    class="w-full sm:max-w-md sm:mx-auto mt-6 px-6 py-4 bg-white dark:bg-gray-900 shadow-md sm:rounded-lg"
    action="{{ route('works.store') }}" method="post" enctype="multipart/form-data"
>
    @csrf
    <input type="hidden" name="type" value="image">

    <div class="mb-4">
        <label
            class="flex flex-col items-center relative cursor-pointer rounded border hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900 focus-within:border-primary-500 focus-within:ring focus-within:ring-primary-100 dark:focus-within:ring-primary-700 overflow-hidden p-4"
            x-data="{ file: null }"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            <div x-text="file ? file.replace(/.+[\\\/]/, '') : '{{ addslashes(__('Select file')) }}'"></div>
            <input id="file" class="opacity-0 absolute" type="file" name="file" x-model="file" required>
        </label>
    </div>

    <div class="mb-4">
        <x-label for="title" :value="__('Title')" />
        <input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')">
    </div>

    <div class="mb-4">
        <x-label for="description" :value="__('Description')" />
        <textarea id="description" class="block mt-1 w-full" name="description" :value="old('description')" rows="3"></textarea>
    </div>

    <div class="mb-4">
        <x-label for="source_url" :value="__('Source URL')" />
        <input id="source_url" class="block mt-1 w-full" type="url" name="source_url" :value="old('source_url')">
    </div>

    <div class="flex justify-end">
        <button type="submit" class="btn btn-primary">{{ __('Add work') }}</button>
    </div>
</form>

<form
    class="w-full sm:max-w-md sm:mx-auto mt-6 px-6 py-4 bg-white dark:bg-gray-900 shadow-md sm:rounded-lg"
    action="{{ route('works.store') }}" method="post" enctype="multipart/form-data"
>
    @csrf
    <input type="hidden" name="type" value="image">

    <div class="mb-4">
        <image-input class="flex flex-col items-center relative cursor-pointer rounded-md border hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900 focus-within:border-primary-500 focus-within:ring focus-within:ring-primary-100 dark:focus-within:ring-primary-700 overflow-hidden p-4" label="{{ __('Select file') }}"></image-input>
    </div>

    <div class="mb-4">
        <x-label for="title" :value="__('Title')" />
        <input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title') }}">
    </div>

    <div class="mb-4">
        <x-label for="description" :value="__('Description')" optional />
        <textarea id="description" class="block mt-1 w-full" name="description" rows="3">{{ old('description') }}</textarea>
    </div>

    <div class="mb-4">
        <x-label for="source_url" :value="__('Source URL')" optional />
        <input id="source_url" class="block mt-1 w-full" type="url" name="source_url" value="{{ old('source_url') }}">
    </div>

    <div class="flex justify-end">
        <button type="submit" class="btn btn-primary">{{ __('Add work') }}</button>
    </div>
</form>

<form
    class="w-full sm:max-w-5xl sm:mx-auto mt-6 px-6 py-4 bg-white dark:bg-gray-900 shadow-md sm:rounded-lg"
    action="{{ route('works.store') }}" method="post" enctype="multipart/form-data"
>
    @csrf
    <input type="hidden" name="type" value="text">

    <div class="mb-4">
        <x-label for="title" :value="__('Title')" />
        <input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title') }}">
    </div>

    <div class="mb-4">
        <x-label for="source_url" :value="__('Source URL')" />
        <input id="source_url" class="block mt-1 w-full" type="url" name="source_url" value="{{ old('source_url') }}">
    </div>

    <div class="mb-4">
        <x-label for="description" :value="__('Content')" />
        <markdown-editor id="description" class="mt-1" name="description" text="{{ old('description') }}"></markdown-editor>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="btn btn-primary">{{ __('Add work') }}</button>
    </div>
</form>

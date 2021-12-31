<template>
    <div class="flex flex-wrap gap-2">
        <div
            class="inline-flex items-stretch bg-gray-200 dark:bg-gray-900 rounded-full text-sm font-semibold text-gray-700 dark:text-gray-300"
            v-for="tag in tags"
            :key="tag.id"
        >
            <a class="px-3 py-1" :href="route('works.index', { tags: tag.name })">
                {{ tag.name }}
                <span class="ml-1 text-primary-600 dark:text-primary-300">{{ tag.works_count }}</span>
            </a>
            <div class="-ml-1">
                <button
                    type="button"
                    @click="removeTag(tag)"
                    class="text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 h-full px-2 -ml-1 z-10"
                    :title="$t('Remove tag')"
                >
                    <span class="sr-only">{{ $t('Remove tag') }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <form class="flex mt-4" @submit.prevent="addTag">
        <input class="flex-1 min-w-0 !rounded-r-none" type="text" v-model="tagName" :placeholder="$t('Add tag')">
        <button type="submit" class="btn btn-primary px-3 rounded-l-none">
            <span class="sr-only">
                {{ $t('Add tag') }}
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
        </button>
    </form>
</template>

<script>
import { ref, toRefs } from 'vue';

export default {
    props: {
        workId: Number,
    },
    setup(props) {
        const { workId } = toRefs(props);
        const tags = ref([]);
        const tagName = ref('');

        const fetchTags = async () => {
            const response = await axios.get(`/api/works/${workId.value}/tags`);
            tags.value = response.data;
        };
        fetchTags();

        const addTag = async () => {
            const response = await axios.post(`/api/works/${workId.value}/tags`, {
                tag: tagName.value,
            });
            tags.value.push(response.data);
            tags.value.sort((a, b) => a.name.localeCompare(b.name));
            tagName.value = '';
        };

        const removeTag = async (tag) => {
            await axios.delete(`/api/works/${workId.value}/tags/${tag.id}`);
            tags.value = tags.value.filter((t) => t.id !== tag.id);
        };

        return {
            tags,
            tagName,
            addTag,
            removeTag,
        };
    },
};
</script>

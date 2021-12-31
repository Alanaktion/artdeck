<template>
    <label>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" v-if="!filename">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
        </svg>
        <img class="rounded" ref="img" v-else>
        <div v-text="filename || label"></div>
        <input id="file" class="opacity-0 absolute" type="file" name="file" @change="onFileChange" required>
    </label>
</template>

<script>
import { ref, toRefs } from 'vue';

// https://stackoverflow.com/a/61754764/873843
function generateThumbnail(file, boundBox = [320, 240]) {
    const reader = new FileReader();
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    return new Promise((resolve, reject) => {
        reader.onload = function(event) {
            const img = new Image()
            img.onload = function() {
                // TODO: make this not stupid (actually compare boundBox to image size)
                const scaleRatio = Math.min(...boundBox) / Math.max(img.width, img.height);
                let w = img.width * scaleRatio;
                let h = img.height * scaleRatio;
                canvas.width = w;
                canvas.height = h;
                ctx.drawImage(img, 0, 0, w, h);
                return resolve(canvas.toDataURL(file.type));
            }
            img.src = event.target.result;
        }
        reader.readAsDataURL(file);
    })
};

export default {
    props: {
        label: {
            type: String,
            default: 'Select file',
        },
    },
    setup(props) {
        const { label } = toRefs(props);
        const filename = ref(null);
        const img = ref(null);

        const onFileChange = (e) => {
            filename.value = e.target.value.replace(/.+[\\\/]/, '');
            generateThumbnail(e.target.files[0]).then(function(dataUrl) {
                img.value.src = dataUrl;
            });
        };

        return { label, filename, img, onFileChange };
    },
}
</script>

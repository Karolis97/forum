<template>
    <div class="bg-white rounded-md border-0 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
        <EditorContent :editor="editor" />
    </div>
</template>
<script setup>

import {EditorContent, useEditor} from "@tiptap/vue-3";
import {StarterKit} from "@tiptap/starter-kit";
import {watch} from "vue";
import {Markdown} from "tiptap-markdown";

const props = defineProps({
    modelValue: '',
});

const emit = defineEmits(['update:modelValue']);

const editor = useEditor({
    extensions: [
        StarterKit,
        Markdown,
    ],
    editorProps: {
        attributes: {
            class: 'min-h-[512px] prose prose-sm max-w-none py-1.5 px-3',
        },
    },
    onUpdate: () => emit('update:modelValue', editor.value?.storage.markdown.getMarkdown())
});

watch(() => props.modelValue, (value) => {
    if (value === editor.value?.storage.markdown.getMarkdown()) {
        return;
    }

    editor.value?.commands.setContent(value);
}, { immediate: true });

</script>

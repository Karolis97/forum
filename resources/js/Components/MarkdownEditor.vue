<template>
    <div v-if="editor" class="bg-white rounded-md border-0 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
        <menu class="flex divide-x border-b">
            <li>
                <button @click="() => editor.chain().focus().toggleBold().run()"
                        type="button"
                        class="px-3 py-2 rounded-tl-md"
                        :class="[editor.isActive('bold') ? 'bg-gray-600 text-white' : 'hover:bg-gray-200 hover:text-black']"
                        title="Bold">
                    <i class="ri-bold"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleItalic().run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('italic') ? 'bg-gray-600 text-white' : 'hover:bg-gray-200 hover:text-black']"
                        title="Italic">
                    <i class="ri-italic"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleStrike().run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('strike') ? 'bg-gray-600 text-white' : 'hover:bg-gray-200 hover:text-black']"
                        title="Strikethrough">
                    <i class="ri-strikethrough"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleBlockquote().run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('blockquote') ? 'bg-gray-600 text-white' : 'hover:bg-gray-200 hover:text-black']"
                        title="Blockquote">
                    <i class="ri-double-quotes-l"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleBulletList().run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('bulletList') ? 'bg-gray-600 text-white' : 'hover:bg-gray-200 hover:text-black']"
                        title="Bullet list">
                    <i class="ri-list-unordered"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleOrderedList().run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('orderedList') ? 'bg-gray-600 text-white' : 'hover:bg-gray-200 hover:text-black']"
                        title="Numeric list">
                    <i class="ri-list-ordered"></i>
                </button>
            </li>
            <li>
                <button @click="promptUserForHref"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('link') ? 'bg-gray-600 text-white' : 'hover:bg-gray-200 hover:text-black']"
                        title="Add link">
                    <i class="ri-link"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleHeading({ level: 2 }).run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('heading', { level: 2 }) ? 'bg-gray-600 text-white' : 'hover:bg-gray-200 hover:text-black']"
                        title="Heading 1">
                    <i class="ri-h-1"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleHeading({ level: 3 }).run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('heading', { level: 3 }) ? 'bg-gray-600 text-white' : 'hover:bg-gray-200 hover:text-black']"
                        title="Heading 2">
                    <i class="ri-h-2"></i>
                </button>
            </li>
            <li>
                <button @click="() => editor.chain().focus().toggleHeading({ level: 4 }).run()"
                        type="button"
                        class="px-3 py-2"
                        :class="[editor.isActive('heading', { level: 4 }) ? 'bg-gray-600 text-white' : 'hover:bg-gray-200 hover:text-black']"
                        title="Heading 3">
                    <i class="ri-h-3"></i>
                </button>
            </li>
        </menu>
        <EditorContent :editor="editor"/>
    </div>
</template>
<script setup>

import {EditorContent, useEditor} from "@tiptap/vue-3";
import {StarterKit} from "@tiptap/starter-kit";
import {Link} from "@tiptap/extension-link";
import {watch} from "vue";
import {Markdown} from "tiptap-markdown";
import "remixicon/fonts/remixicon.css";

const props = defineProps({
    modelValue: '',
});

const emit = defineEmits(['update:modelValue']);

const editor = useEditor({
    extensions: [
        StarterKit.configure({
            heading: [2, 3, 4],
            code: false,
            codeBlock: false,
        }),
        Link,
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
}, {immediate: true});

const promptUserForHref = () => {
    if (editor?.value.isActive('link')) {
        return editor?.value.chain().unsetLink().run();
    }

    const href = prompt('Where do you want to link to?');

    if (! href) {
        return editor?.value.chain().focus().run();
    }

    return editor?.value.chain().focus().setLink({ href }).run();
};
</script>

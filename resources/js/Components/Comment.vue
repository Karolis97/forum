<template>
    <div class="sm:flex">
        <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
            <img :src="comment.user.profile_photo_url" class="h-10 w-10 rounded-full" alt=""/>
        </div>
        <div class="flex-1">
            <p class="mt-1 break-all">{{ comment.body }}</p>
            <span class="first-letter:uppercase block pt-1 text-xs text-gray-600">
                By {{ comment.user.name }} {{ relativeDate(comment.created_at) }} ago
            </span>
            <div class="mt-2 flex justify-end space-x-3 empty:hidden">
                <form @submit.prevent="$emit('edit', comment.id)" v-if="comment.can?.update">
                    <button class="font-mono text-xs hover:font-semibold">Edit</button>
                </form>
                <form @submit.prevent="$emit('delete', comment.id)" v-if="comment.can?.delete">
                    <button class="font-mono text-xs text-red-700 hover:font-semibold">Delete</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import {relativeDate} from "@/Utilities/date.js";

const props = defineProps(['comment']);

const emit = defineEmits(['delete', 'edit']);
</script>

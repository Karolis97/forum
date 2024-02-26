<template>
    <AppLayout :title="post.title">
        <Container>
            <h1 class="text-2xl font-bold">{{ post.title }}</h1>
            <span class="text-sm text-gray-600 block mt-1">{{ formattedDate }} ago by {{ post.user.name }}</span>

            <article class="mt-6">
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>

            <div class="mt-12">
                <h2 class="text-xl font-semibold">Comments</h2>

                <form v-if="$page.props.auth.user"
                      @submit.prevent="() => commentIdBeingEdited ? updateComment() : addComment()" class="mt-4">
                    <div class="space-y-3 pb-2">
                        <InputLabel for="body" class="sr-only">Comment</InputLabel>
                        <TextArea ref="commentTextAreaRef" id="body" v-model="commentForm.body" rows="4"
                                  placeholder="Write a comment for this post!"/>
                        <InputError :message="commentForm.errors.body"></InputError>
                    </div>

                    <PrimaryButton type="submit" class="mt-3" :disabled="commentForm.processing"
                                   v-text="commentIdBeingEdited ? 'Update comment' : 'Add comment'"></PrimaryButton>
                    <SecondaryButton v-if="commentIdBeingEdited" @click="cancelEditComment" class="ml-2">Cancel
                    </SecondaryButton>
                </form>

                <ul class="divide-y mt-2">
                    <li v-for="comment in comments.data" :key="comment.id" class="px-2 py-4">
                        <Comment @edit="editComment" @delete="deleteComment" :comment="comment"/>
                    </li>
                </ul>

                <Pagination :meta="comments.meta" :only="['comments']"/>
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import {relativeDate} from "@/Utilities/date.js";
import Comment from "@/Components/Comment.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {router, useForm} from "@inertiajs/vue3";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import {computed, ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useConfirm} from "@/Utilities/Composables/useConfirm.js";

const props = defineProps(['post', 'comments']);

const formattedDate = relativeDate(props.post.created_at);

const commentForm = useForm({
    body: '',
});

const commentTextAreaRef = ref(null);
const commentIdBeingEdited = ref(null);
const commentBeingEdited = computed(() => props.comments.data.find(comment => comment.id === commentIdBeingEdited.value));

const editComment = (commentId) => {
    commentIdBeingEdited.value = commentId;
    commentForm.body = commentBeingEdited.value?.body;
    commentTextAreaRef.value?.focus();
};

const cancelEditComment = () => {
    commentIdBeingEdited.value = null;
    commentForm.reset();
};

const addComment = () => commentForm.post(route('posts.comments.store', props.post.id), {
    preserveScroll: true,
    onSuccess: () => commentForm.reset(),
});

const { confirmation } = useConfirm();

const updateComment = async () => {
    if (! await confirmation('Are you sure you want to update this comment?')) {
        commentTextAreaRef.value?.focus();
        return;
    }

    commentForm.put(route('comments.update', {
        comment: commentIdBeingEdited.value,
        page: props.comments.meta.current_page,
    }), {
        preserveScroll: true,
        onSuccess: cancelEditComment,
    })
};

const deleteComment = async (commentId) => {
    if (! await confirmation('Are you sure want to delete this comment?')) {
        return;
    }

    router.delete(route('comments.destroy', {
        comment: commentId,
        page: props.comments.meta.current_page,
    }), {
        preserveScroll: true,
    });
};
</script>

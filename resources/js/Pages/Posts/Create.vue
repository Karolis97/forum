<template>
    <AppLayout title="Create a post">
        <Container>
            <h1 class="text-2xl font-bold">Create a post</h1>

            <form @submit.prevent="createPost" class="mt-6 flex flex-col space-y-3">
                <div>
                    <InputLabel for="title" class="sr-only">Title</InputLabel>
                    <TextInput id="title" class="w-full" v-model="form.title" placeholder="Give it a great title..." />
                    <InputError :message="form.errors.title" class="mt-1" />
                </div>

                <div>
                    <InputLabel for="body" class="sr-only">Body</InputLabel>
                    <TextArea id="body" v-model="form.body" rows="20" />
                    <InputError :message="form.errors.body" class="mt-1" />
                </div>

                <div>
                    <PrimaryButton type="submit">Create post</PrimaryButton>
                </div>
            </form>
        </Container>
    </AppLayout>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import TextArea from "@/Components/TextArea.vue";

const form = useForm({
    'title': '',
    'body': '',
});

const createPost = () => form.post(route('posts.store'));
</script>

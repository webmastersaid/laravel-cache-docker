<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    status: {
        type: String,
    },
    post: {
        type: Object
    }
});

const form = useForm({
    title: props.post.title,
    content: props.post.content,
    views: 0,
});

const submit = () => {
    form.patch(route('post.update', props.post.id), {
        onFinish: () => {
            form.reset('title')
            form.reset('content')
        },
    });
};

</script>
<template>
    <Head title="Create post" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex gap-1 justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit post</h2>
                <a :href="route('post.show', post.id)" class="text-blue-700">
                    Go back to post
                </a>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" required
                            autofocus />
                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="content" value="Content" />
                        <TextArea id="content" type="text" class="mt-1 block w-full" v-model="form.content" required />
                        <InputError class="mt-2" :message="form.errors.content" />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
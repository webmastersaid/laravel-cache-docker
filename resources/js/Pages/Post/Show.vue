<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps([
    'post',
    'author',
])

</script>
<template>
    <Head title="Create post" />
    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post</h2>
            <div class="flex gap-1 justify-between">
                <a :href="route('post.index')" class="text-blue-700">
                    Go back to posts
                </a>
                <a v-if="$page.props.auth.user" :href="route('post.edit', post.id)"
                    class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-blue-700">
                    Edit
                </a>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-xl">{{ post.title }}</h2>
                <div class="pb-2">
                    <p class="text-md">
                        {{ post.content }}
                    </p>
                </div>
                <div class="flex gap-1 justify-between">
                    <div class="text-sm">
                        Author: {{ author.name }}
                    </div>
                    <div class="text-sm">
                        Views: {{ post.views }}
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
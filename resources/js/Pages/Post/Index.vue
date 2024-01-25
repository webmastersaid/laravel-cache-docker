<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps([
    'posts',
])

</script>
<template>
    <Head title="Create post" />
    <MainLayout>
        <template #header>
            <div class="flex gap-1 justify-between">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h1>
                <a v-if="$page.props.auth.user" :href="route('post.create')"
                    class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-blue-700">
                    Create post
                </a>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-for="post in posts" class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2">
                    <a :href="route('post.show', post.id)">
                        <div class="p-6 text-gray-900">
                            <h2 class="text-xl">{{ post.title }}</h2>
                            <div class="pb-2">
                                <p class="text-md">
                                    {{ post.content }}
                                </p>
                            </div>
                            <div class="flex gap-1 justify-between">
                                <div class="text-sm">
                                    Views: {{ post.views }}
                                </div>
                                <div>
                                    <a v-if="$page.props.auth.user" :href="route('post.show', post.id)" class="text-blue-700">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
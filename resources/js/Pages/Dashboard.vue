<script setup>
import { ref, computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/Components/Card.vue';

// Get user and posts from Inertia
const page = usePage();
const user = computed(() => page.props.auth.user || { id: null, first_name: 'Guest' });
const posts = computed(() => page.props.posts || []);

// Modal state
const isModalOpen = ref(false);
const isEditing = ref(false); // ✅ Track if we are editing
const post = ref({
    title: '',
    type: 'news',
    message: '',
    author_id: computed(() => user.value.id),
});
const postId = ref(null); // ✅ Track the post being edited

// Open modal for creating a new post
const openCreateModal = () => {
    post.value = { title: '', type: 'news', message: '', author_id: user.value.id };
    postId.value = null;
    isEditing.value = false;
    isModalOpen.value = true;
};

// Open modal for editing a post
const openEditModal = (existingPost) => {
    post.value = { ...existingPost };
    postId.value = existingPost.id;
    isEditing.value = true;
    isModalOpen.value = true;
};

// Handle form submission (Create or Update)
const submitPost = () => {
    if (isEditing.value) {
        // Update existing post
        router.put(route('posts.update', postId.value), post.value, {
            onSuccess: () => {
                isModalOpen.value = false;
            }
        });
    } else {
        // Create new post
        router.post(route('posts.store'), post.value, {
            onSuccess: () => {
                isModalOpen.value = false;
            }
        });
    }
};

// Handle post deletion
const deletePost = (id) => {
    if (confirm("Are you sure you want to delete this post?")) {
        router.delete(route('posts.destroy', id));
    }
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex">
                <div class="w-[50%] flex items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Dashboard
                    </h2>
                </div>
                <div class="w-[50%] flex justify-end items-center">
                    <button 
                        @click="openCreateModal" 
                        class="border p-2 hover:bg-gray-100 rounded-md">
                        Create +
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-3 gap-3">
                    <Card v-for="post in posts" 
                          :key="post.id" 
                          :post="post" 
                          @delete="deletePost(post.id)" 
                          @edit="openEditModal" />
                </div>
            </div>
        </div>

        <!-- Modal (Create & Edit) -->
        <div 
            v-if="isModalOpen" 
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-[600px] max-w-2xl">
                <h2 class="text-xl font-semibold mb-4">
                    {{ isEditing ? 'Edit Post' : 'Whats on your mind?' }}
                </h2>
                
                <form @submit.prevent="submitPost">
                    <!-- Title Input -->
                    <label class="block text-gray-700">Title</label>
                    <input 
                        type="text" 
                        v-model="post.title" 
                        class="w-full p-2 border rounded-md mb-3" 
                        placeholder="Enter title" 
                        required>
                    
                    <!-- Type Dropdown -->
                    <label class="block text-gray-700">Type</label>
                    <select 
                        v-model="post.type" 
                        class="w-full p-2 border rounded-md mb-3">
                        <option value="news">News</option>
                        <option value="update">Update</option>
                        <option value="task">Task</option>
                    </select>

                    <!-- Message Input -->
                    <label class="block text-gray-700">Message</label>
                    <textarea 
                        v-model="post.message" 
                        class="w-full p-2 border rounded-md mb-3 h-32 resize-none" 
                        placeholder="Write your message here" 
                        required>
                    </textarea>

                    <!-- Hidden Author ID Field -->
                    <input type="hidden" v-model="post.author_id">

                    <!-- Buttons -->
                    <div class="mt-4 flex justify-end gap-2">
                        <button 
                            @click="isModalOpen = false" 
                            type="button"
                            class="px-4 py-2 bg-gray-500 text-white rounded">
                            Close
                        </button>
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            {{ isEditing ? 'Update' : 'Submit' }}
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </AppLayout>
</template>

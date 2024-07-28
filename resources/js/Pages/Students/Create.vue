<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import axios from '@/axios'; // Assuming you have an axios.js file as shown above

defineProps({
    classes: {        
        type: Object,
    }
});

const form = useForm({
    name: '',
    email: '',
    class_id: '',
    section_id: '',
});

const sections = ref([]);

watch(
    () => form.class_id, 
    (newValue) => {
        if (newValue) {
            getSections(newValue);
        } else {
            sections.value = [];
        }
    }
);

const getSections = async (class_id) => {
    try {
        const response = await axios.get(`/api/sections?class_id=${class_id}`);
        sections.value = response.data;
        //console.log(sections);
    } catch (error) {
        console.log(error.message);
        if (error.response) {
            // The request was made, and the server responded with a status code that falls out of the range of 2xx
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
        } else if (error.request) {
            // The request was made, but no response was received
            console.log(error.request);
        } else {
            // Something happened in setting up the request that triggered an Error
            console.log('Error', error.message);
        }
    }
};

const handleSubmit = async () => {
    try {
        await form.post('/students');
    } catch (error) {
        console.log(error.message);
        // Add user feedback for error
    }
};
</script>

<template>
    <Head title="Create new Student" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Student
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                    <form @submit.prevent="handleSubmit">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                                <div>
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Student Information
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Use this form to create a new student.
                                    </p>
                                </div>

                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            id="name"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{
                                                'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                                                    true,
                                            }"
                                        />
                                        
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="email" class="block text-sm font-medium text-gray-700">
                                            Email Address
                                        </label>
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            id="email"
                                            autocomplete="email"
                                            class="mt-1 block w-full border border-gray-300 rounded-md 
                                            shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 
                                            focus:border-indigo-500 sm:text-sm"
                                            :class="{
                                                'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                                                    true,
                                            }"
                                        />
                                        
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label
                                            for="class_id"
                                            class="block text-sm font-medium text-gray-700"
                                            >Class</label
                                        >
                                        <select
                                            v-model="form.class_id"
                                            id="class_id"
                                            class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{
                                                'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                                                    true,
                                            }"
                                        >
                                            <option value="">Select a Class</option>
                                            <option v-for="item in classes.data" :key="item.id" :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>                                    
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="section_id" class="block text-sm font-medium text-gray-700">
                                            Section
                                        </label>
                                        <select
                                            v-model="form.section_id"
                                            id="section_id"
                                            class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{
                                                'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                                                    true,
                                            }"
                                        >
                                            <option value="">Select a Section</option>
                                            <option v-for="section in sections.data" :key="section.id" :value="section.id">
                                                {{ section.name }}
                                            </option>
                                        </select>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button class="inline-flex items-center px-4 py-2 border border-transparent 
                                    text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 
                                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-indigo-600 border border-transparent rounded-md 
                                    shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white 
                                    hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-indigo-500">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>    
</template>

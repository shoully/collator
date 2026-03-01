<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    projects: {
        type: Array,
        default: () => []
    },
    user: Object
});

const getStatusColor = (status) => {
    switch(status) {
        case 'active': return 'bg-growth-100 text-growth-800 border-growth-200';
        case 'completed': return 'bg-gray-100 text-gray-800 border-gray-200';
        case 'cancelled': return 'bg-error-100 text-error-800 border-error-200';
        default: return 'bg-brand-100 text-brand-800 border-brand-200';
    }
};
</script>

<template>
    <Head title="Projects" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center w-full">
                <div>
                    <h2 class="font-semibold text-2xl text-gray-900 leading-tight tracking-tight">
                        Projects Workspace
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Manage your active collaborations and documents.</p>
                </div>
                <Link v-if="user.type === 'Mentor'" :href="route('projects.create')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    New Project
                </Link>
            </div>
        </template>

        <div class="space-y-6 pb-10">
            <!-- Project Grid -->
            <div v-if="projects.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="project in projects" :key="project.id" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow group flex flex-col">
                    <div class="p-6 flex-1">
                        <div class="flex justify-between items-start mb-4">
                            <span :class="['px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full border', getStatusColor(project.status)]">
                                {{ project.status ? project.status.charAt(0).toUpperCase() + project.status.slice(1) : 'Active' }}
                            </span>
                            
                            <!-- Dropdown Menu (Dummy) -->
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-brand-600 transition-colors">
                            <Link :href="route('projects.show', project.id)">{{ project.title }}</Link>
                        </h3>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ project.description || 'No description provided.' }}</p>
                        
                        <!-- Metadata -->
                        <div class="flex items-center text-xs text-gray-500 space-x-4 mb-4">
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ new Date(project.project_date).toLocaleDateString() }}
                            </span>
                            <span v-if="project.file" class="flex items-center">
                                <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                1 Attachment
                            </span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                        <div class="flex -space-x-2 overflow-hidden">
                            <!-- Dummy Avatars -->
                            <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-brand-100 flex items-center justify-center text-brand-700 text-xs font-bold">M</div>
                            <div v-if="project.mentee" class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-growth-100 flex items-center justify-center text-growth-700 text-xs font-bold">S</div>
                        </div>
                        
                        <Link :href="route('projects.show', project.id)" class="text-sm font-medium text-brand-600 hover:text-brand-500 flex items-center">
                            Open Workspace
                            <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-16 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No projects yet</h3>
                <p class="mt-2 text-sm text-gray-500 max-w-sm mx-auto">Get started by creating a new project to collaborate with your mentees, share documents, and track progress.</p>
                <div class="mt-6">
                    <Link v-if="user.type === 'Mentor'" :href="route('projects.create')" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-brand-600 hover:bg-brand-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create your first project
                    </Link>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

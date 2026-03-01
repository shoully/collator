<script setup>
import { ref } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    project: Object,
    user: Object,
    documents: {
        type: Array,
        default: () => [
            { id: 1, name: 'Marketing_Strategy_v2.pdf', type: 'pdf', size: '2.4 MB', date: 'Oct 12' },
            { id: 2, name: 'Q3_Financials.xlsx', type: 'spreadsheet', size: '1.1 MB', date: 'Oct 10' },
            { id: 3, name: 'Brand_Guidelines.docx', type: 'document', size: '840 KB', date: 'Oct 05' },
        ]
    }
});

const getFileIcon = (type) => {
    switch(type) {
        case 'pdf': return 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z';
        case 'spreadsheet': return 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
        default: return 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z';
    }
};

const getFileColor = (type) => {
    switch(type) {
        case 'pdf': return 'text-error-500 bg-error-50';
        case 'spreadsheet': return 'text-growth-500 bg-growth-50';
        default: return 'text-brand-500 bg-brand-50';
    }
};
</script>

<template>
    <Head :title="project ? project.title : 'Project Workspace'" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link :href="route('projects.index')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </Link>
                <div>
                    <div class="flex items-center space-x-3">
                        <h2 class="font-semibold text-2xl text-gray-900 leading-tight tracking-tight">
                            {{ project ? project.title : 'Project Title' }}
                        </h2>
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-4 font-semibold rounded-full border bg-growth-100 text-growth-800 border-growth-200">
                            Active
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Workspace and Document Hub</p>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-10">
            <!-- Left Column: Details -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Project Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Project Details</h3>
                    <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                        {{ project ? project.description : 'This is the main workspace for your project. Collaborate here.' }}
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Date Created</span>
                            <span class="font-medium text-gray-900">{{ project ? new Date(project.project_date).toLocaleDateString() : 'Today' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Owner</span>
                            <div class="flex items-center">
                                <div class="h-5 w-5 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 text-[10px] font-bold mr-2">O</div>
                                <span class="font-medium text-gray-900">Mentor</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Card -->
                <div class="bg-brand-50 rounded-xl border border-brand-100 p-6">
                    <h3 class="text-sm font-bold text-brand-900 mb-2">Need to discuss this project?</h3>
                    <p class="text-xs text-brand-700 mb-4">Schedule a specific meeting or drop a message in the chat.</p>
                    <button class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                        Open Chat
                    </button>
                </div>
            </div>

            <!-- Right Column: Documents -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Document Hub</h3>
                            <p class="text-xs text-gray-500 mt-1">Shared files and resources for this project.</p>
                        </div>
                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                            <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Upload File
                        </button>
                    </div>
                    
                    <ul class="divide-y divide-gray-100">
                        <!-- Project Main File (if exists) -->
                        <li v-if="project && project.file" class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between group">
                            <div class="flex items-center min-w-0 flex-1">
                                <div class="h-10 w-10 flex-shrink-0 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center mr-4">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ project.filename || 'Project Document' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">Main Project File</p>
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <a :href="route('projects.download', project.id)" class="text-brand-600 hover:text-brand-900 text-sm font-medium bg-brand-50 px-3 py-1.5 rounded-md opacity-0 group-hover:opacity-100 transition-opacity">
                                    Download
                                </a>
                            </div>
                        </li>

                        <!-- Dummy Document List -->
                        <li v-for="doc in documents" :key="doc.id" class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between group">
                            <div class="flex items-center min-w-0 flex-1">
                                <div :class="['h-10 w-10 flex-shrink-0 rounded-lg flex items-center justify-center mr-4', getFileColor(doc.type)]">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="getFileIcon(doc.type)" />
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ doc.name }}</p>
                                    <div class="flex text-xs text-gray-500 mt-0.5 space-x-2">
                                        <span>{{ doc.size }}</span>
                                        <span>&bull;</span>
                                        <span>Uploaded {{ doc.date }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button class="text-gray-400 hover:text-gray-600 p-1.5">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button class="text-brand-600 hover:text-brand-900 text-sm font-medium bg-brand-50 px-3 py-1.5 rounded-md">
                                    Download
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

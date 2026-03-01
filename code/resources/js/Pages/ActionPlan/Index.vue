<script setup>
import { ref } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';

// Dummy data representing "Areas to Develop" and nested "Activities"
const developmentAreas = ref([
    {
        id: 1,
        title: 'Communication Skills',
        progress: 60,
        expanded: true,
        activities: [
            { id: 101, title: 'Interview Practice', status: 'done', priority: 'High', date: 'Oct 12' },
            { id: 102, title: 'Presentation Draft', status: 'on_track', priority: 'Medium', date: 'Oct 20' },
            { id: 103, title: 'Networking Event', status: 'on_hold', priority: 'Low', date: 'Nov 05' },
        ]
    },
    {
        id: 2,
        title: 'Digital Marketing',
        progress: 25,
        expanded: false,
        activities: [
            { id: 201, title: 'SEO Basics Course', status: 'on_track', priority: 'High', date: 'Oct 15' },
            { id: 202, title: 'Create Ad Campaign', status: 'blocked', priority: 'Medium', date: 'Oct 22' },
        ]
    },
    {
        id: 3,
        title: 'Business Model',
        progress: 100,
        expanded: false,
        activities: [
            { id: 301, title: 'Complete Lean Canvas', status: 'done', priority: 'High', date: 'Sep 30' },
            { id: 302, title: 'Competitor Analysis', status: 'done', priority: 'Medium', date: 'Oct 05' },
        ]
    }
]);

const toggleArea = (id) => {
    const area = developmentAreas.value.find(a => a.id === id);
    if (area) area.expanded = !area.expanded;
};

const getStatusColor = (status) => {
    switch(status) {
        case 'done': return 'bg-growth-100 text-growth-800 border-growth-200';
        case 'on_track': return 'bg-brand-100 text-brand-800 border-brand-200';
        case 'on_hold': return 'bg-gray-100 text-gray-800 border-gray-200';
        case 'blocked': return 'bg-error-100 text-error-800 border-error-200';
        default: return 'bg-gray-100 text-gray-800 border-gray-200';
    }
};

const getStatusLabel = (status) => {
    switch(status) {
        case 'done': return 'Done';
        case 'on_track': return 'On Track';
        case 'on_hold': return 'On Hold';
        case 'blocked': return 'Blocked';
        default: return 'Unknown';
    }
};
</script>

<template>
    <Head title="Action Plan" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center w-full">
                <div>
                    <h2 class="font-semibold text-2xl text-gray-900 leading-tight tracking-tight">
                        Action Plan
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Track your development areas and related activities.</p>
                </div>
                <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Development Area
                </button>
            </div>
        </template>

        <div class="space-y-4 pb-10">
            <!-- Development Areas Accordion -->
            <div v-for="area in developmentAreas" :key="area.id" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-200">
                
                <!-- Area Header (Clickable) -->
                <button @click="toggleArea(area.id)" class="w-full px-6 py-5 flex items-center justify-between bg-white hover:bg-gray-50 focus:outline-none transition-colors">
                    <div class="flex items-center flex-1">
                        <!-- Chevron -->
                        <div class="mr-4 text-gray-400 transition-transform duration-200" :class="{ 'transform rotate-90': area.expanded }">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        
                        <!-- Title & Progress -->
                        <div class="flex-1 text-left">
                            <h3 class="text-lg font-semibold text-gray-900" :class="{'line-through text-gray-500': area.progress === 100}">
                                {{ area.title }}
                            </h3>
                            <div class="mt-2 flex items-center max-w-md">
                                <div class="w-full bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="h-2 rounded-full transition-all duration-500" 
                                         :class="area.progress === 100 ? 'bg-growth-500' : 'bg-brand-500'"
                                         :style="`width: ${area.progress}%`"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-500">{{ area.progress }}%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ml-4 flex items-center space-x-3">
                        <span class="text-sm text-gray-500 font-medium">{{ area.activities.length }} Activities</span>
                        <!-- Quick Add Activity button stops propagation so it doesn't toggle accordion -->
                        <button @click.stop class="text-gray-400 hover:text-brand-600 p-2 rounded-full hover:bg-brand-50 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </button>

                <!-- Expanded Activities List -->
                <transition name="slide-fade">
                <div v-show="area.expanded" class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                    <ul v-if="area.activities.length > 0" class="space-y-3">
                        <li v-for="activity in area.activities" :key="activity.id" class="bg-white border border-gray-200 rounded-lg p-4 flex items-center justify-between hover:shadow-md transition-shadow group">
                            
                            <div class="flex items-center flex-1">
                                <!-- Checkbox visual -->
                                <button class="flex-shrink-0 mr-4 h-6 w-6 rounded border flex items-center justify-center transition-colors"
                                        :class="activity.status === 'done' ? 'bg-growth-500 border-growth-500 text-white' : 'border-gray-300 bg-white hover:border-brand-500'">
                                    <svg v-if="activity.status === 'done'" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-900" :class="{'line-through text-gray-400': activity.status === 'done'}">
                                        {{ activity.title }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">Due: {{ activity.date }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <!-- Priority -->
                                <span class="text-xs font-medium text-gray-500 flex items-center">
                                    <svg class="h-3 w-3 mr-1" :class="{'text-error-500': activity.priority === 'High', 'text-warning-500': activity.priority === 'Medium', 'text-gray-400': activity.priority === 'Low'}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ activity.priority }}
                                </span>
                                
                                <!-- Status Badge -->
                                <span :class="['px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full border', getStatusColor(activity.status)]">
                                    {{ getStatusLabel(activity.status) }}
                                </span>
                                
                                <!-- Actions Menu (Dummy) -->
                                <button class="text-gray-400 hover:text-gray-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>
                            </div>
                        </li>
                    </ul>
                    
                    <!-- Empty state for no activities -->
                    <div v-else class="text-center py-6 bg-white border border-dashed border-gray-300 rounded-lg">
                        <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No activities added yet.</p>
                        <button class="mt-3 text-sm font-medium text-brand-600 hover:text-brand-500">Add an activity</button>
                    </div>
                </div>
                </transition>

            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

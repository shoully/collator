<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

// Dummy data for the prototype
const mentorshipCycle = {
    daysTotal: 90,
    daysCompleted: 45,
    percentage: 50,
};

const stats = [
    { name: 'Completed Activities', stat: '12', icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', color: 'text-growth-500', bg: 'bg-growth-50' },
    { name: 'Active Projects', stat: '2', icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', color: 'text-brand-500', bg: 'bg-brand-50' },
    { name: 'Unread Messages', stat: '3', icon: 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', color: 'text-warning-500', bg: 'bg-yellow-50' },
];

const upcomingEvents = [
    { id: 1, type: 'meeting', title: 'Weekly Sync with Mentor', time: 'Today, 2:00 PM', icon: 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z' },
    { id: 2, type: 'task', title: 'Submit Marketing Plan Draft', time: 'Tomorrow, 5:00 PM', icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2' },
];
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight tracking-tight">
                    Welcome back, {{ $page.props.auth.user.name }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Here is what's happening with your mentorship journey today.</p>
            </div>
        </template>

        <div class="space-y-6">
            
            <!-- Hero: 90-Day Cycle Progress -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Mentorship Cycle</h3>
                            <p class="text-sm text-gray-500">Day {{ mentorshipCycle.daysCompleted }} of {{ mentorshipCycle.daysTotal }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-extrabold text-brand-600">{{ mentorshipCycle.percentage }}%</span>
                            <span class="text-sm font-medium text-gray-500 block">Completed</span>
                        </div>
                    </div>
                    
                    <!-- Beautiful Progress Bar -->
                    <div class="relative w-full h-4 bg-gray-100 rounded-full overflow-hidden">
                        <div class="absolute top-0 left-0 h-full bg-brand-500 rounded-full transition-all duration-1000 ease-out" :style="{ width: `${mentorshipCycle.percentage}%` }">
                            <!-- Shine effect on the bar -->
                            <div class="absolute top-0 left-0 right-0 bottom-0 bg-white opacity-20 w-full" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); transform: skewX(-20deg);"></div>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between text-xs font-medium text-gray-400">
                        <span>Kickoff</span>
                        <span>Midpoint</span>
                        <span>Graduation</span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div v-for="item in stats" :key="item.name" class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 p-5 flex items-center">
                    <div :class="[item.bg, item.color, 'p-3 rounded-lg mr-4']">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">{{ item.name }}</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{ item.stat }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Up Next Feed -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-base font-bold text-gray-900">Up Next</h3>
                        <Link href="#" class="text-sm font-medium text-brand-600 hover:text-brand-500">View Calendar</Link>
                    </div>
                    
                    <div class="space-y-4">
                        <div v-for="event in upcomingEvents" :key="event.id" class="flex items-start p-4 rounded-lg border border-gray-50 hover:bg-gray-50 transition-colors">
                            <div :class="[event.type === 'meeting' ? 'bg-brand-50 text-brand-600' : 'bg-growth-50 text-growth-600', 'p-2 rounded-md mr-4 flex-shrink-0']">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="event.icon" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ event.title }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ event.time }}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <button v-if="event.type === 'meeting'" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                                    Join
                                </button>
                                <button v-else class="text-gray-400 hover:text-growth-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div v-if="upcomingEvents.length === 0" class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming events</h3>
                            <p class="mt-1 text-sm text-gray-500">Your schedule is clear for now.</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions (Replaces old clunky buttons) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-5">Quick Actions</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <Link :href="route('communications.index')" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-200 rounded-xl hover:border-brand-500 hover:bg-brand-50 transition-colors group">
                            <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900 group-hover:text-brand-700">Request Meeting</span>
                        </Link>
                        
                        <Link :href="route('action-plan.index')" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-200 rounded-xl hover:border-growth-500 hover:bg-growth-50 transition-colors group">
                            <svg class="w-8 h-8 text-gray-400 group-hover:text-growth-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900 group-hover:text-growth-700">Add Activity</span>
                        </Link>
                        
                        <Link :href="route('projects.index')" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-200 rounded-xl hover:border-brand-500 hover:bg-brand-50 transition-colors group col-span-2">
                            <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900 group-hover:text-brand-700">Upload Document</span>
                        </Link>
                    </div>
                </div>
            </div>

        </div>
    </BreezeAuthenticatedLayout>
</template>

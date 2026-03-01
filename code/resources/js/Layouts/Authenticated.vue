<script setup>
import { ref } from 'vue';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/inertia-vue3';

const showingSidebar = ref(false);

const navigation = [
  { name: 'Dashboard', href: route('dashboard'), current: route().current('dashboard'), icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
  { name: 'Action Plan', href: route('action-plan.index'), current: route().current('action-plan.*'), icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4' },
  { name: 'Projects', href: route('projects.index'), current: route().current('projects.*'), icon: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z' },
  { name: 'Communications', href: route('communications.index'), current: route().current('communications.*'), icon: 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z' },
];
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex">
        
        <!-- Mobile Sidebar Backdrop -->
        <div v-show="showingSidebar" class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 transition-opacity md:hidden" @click="showingSidebar = false"></div>

        <!-- Sidebar -->
        <div :class="[showingSidebar ? 'translate-x-0' : '-translate-x-full', 'fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0']">
            <div class="flex items-center justify-center h-16 border-b border-gray-200 bg-white">
                <Link :href="route('dashboard')" class="flex items-center gap-2">
                    <BreezeApplicationLogo class="h-8 w-auto text-brand-600" />
                    <span class="text-xl font-bold text-gray-900 tracking-tight">Collator</span>
                </Link>
            </div>

            <div class="overflow-y-auto h-full pb-20 pt-4 px-3">
                <div class="mb-6 px-3">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Main Menu</p>
                </div>
                <nav class="space-y-1">
                    <Link v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors']">
                        <svg :class="[item.current ? 'text-brand-600' : 'text-gray-400 group-hover:text-gray-500', 'flex-shrink-0 -ml-1 mr-3 h-5 w-5']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" :d="item.icon" />
                        </svg>
                        <span class="truncate">{{ item.name }}</span>
                    </Link>
                </nav>
            </div>
            
            <!-- User Profile in Sidebar (Bottom) -->
            <div class="absolute bottom-0 w-full border-t border-gray-200 bg-white p-4">
                <BreezeDropdown align="top" width="48">
                    <template #trigger>
                        <button class="flex items-center w-full focus:outline-none group">
                            <div class="flex-shrink-0">
                                <div class="h-9 w-9 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold text-sm">
                                    {{ $page.props.auth.user.name.charAt(0) }}
                                </div>
                            </div>
                            <div class="ml-3 flex-1 text-left">
                                <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900 truncate">{{ $page.props.auth.user.name }}</p>
                                <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700 truncate">Mentee</p>
                            </div>
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <BreezeDropdownLink href="#">Profile Settings</BreezeDropdownLink>
                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">Log Out</BreezeDropdownLink>
                    </template>
                </BreezeDropdown>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10">
                <div class="flex items-center">
                    <button @click="showingSidebar = true" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-500 -ml-2 p-2 rounded-md mr-4">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <slot name="header">
                        <h1 class="text-xl font-semibold text-gray-800 tracking-tight">Dashboard</h1>
                    </slot>
                </div>
                
                <div class="flex items-center gap-4">
                    <button class="text-gray-400 hover:text-gray-500 relative">
                        <span class="sr-only">View notifications</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-warning-500 ring-2 ring-white"></span>
                    </button>
                </div>
            </header>

            <!-- Main Scrollable Content -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

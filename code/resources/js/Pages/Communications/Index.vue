<script setup>
import { ref } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';

// Dummy state
const activeTab = ref('chat'); // 'chat' or 'meetings'
const messageText = ref('');

// Dummy Data: Chat
const currentContact = ref({ name: 'Sarah Jenkins', role: 'Mentor', avatar: 'S', status: 'Online' });
const messages = ref([
    { id: 1, text: 'Hi! Are we still on for our sync tomorrow?', sender: 'them', time: '10:30 AM' },
    { id: 2, text: 'Yes, absolutely. I have uploaded the draft for the marketing plan we discussed.', sender: 'me', time: '10:35 AM' },
    { id: 3, text: 'Perfect. I will review it before the call.', sender: 'them', time: '10:37 AM' },
]);

const sendMessage = () => {
    if (messageText.value.trim() === '') return;
    messages.value.push({
        id: Date.now(),
        text: messageText.value,
        sender: 'me',
        time: 'Just now'
    });
    messageText.value = '';
    
    // Simulate reply
    setTimeout(() => {
        messages.value.push({
            id: Date.now() + 1,
            text: 'Sounds good!',
            sender: 'them',
            time: 'Just now'
        });
    }, 2000);
};

// Dummy Data: Meetings
const meetings = ref([
    { id: 1, title: 'Weekly Sync', date: 'Tomorrow, 2:00 PM', status: 'upcoming', link: 'https://zoom.us/j/123', with: 'Sarah Jenkins' },
    { id: 2, title: 'Marketing Plan Review', date: 'Oct 20, 10:00 AM', status: 'requested', link: null, with: 'Sarah Jenkins' },
    { id: 3, title: 'Kickoff Call', date: 'Oct 01, 1:00 PM', status: 'done', link: null, with: 'Sarah Jenkins' },
]);

const getMeetingStatusColor = (status) => {
    switch(status) {
        case 'upcoming': return 'bg-brand-100 text-brand-800 border-brand-200';
        case 'requested': return 'bg-warning-100 text-warning-800 border-warning-200';
        case 'done': return 'bg-gray-100 text-gray-800 border-gray-200';
        default: return 'bg-gray-100 text-gray-800 border-gray-200';
    }
};
</script>

<template>
    <Head title="Communications" />

    <BreezeAuthenticatedLayout>
        <!-- Custom Header with Tabs -->
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between w-full">
                <div>
                    <h2 class="font-semibold text-2xl text-gray-900 leading-tight tracking-tight">
                        Communications
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Chat and schedule meetings with your mentor/mentee.</p>
                </div>
                
                <!-- Custom Tabs -->
                <div class="mt-4 sm:mt-0 flex p-1 space-x-1 bg-gray-100/80 rounded-lg">
                    <button @click="activeTab = 'chat'" 
                            :class="[activeTab === 'chat' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700', 'px-4 py-1.5 text-sm font-medium rounded-md transition-all']">
                        Live Chat
                    </button>
                    <button @click="activeTab = 'meetings'" 
                            :class="[activeTab === 'meetings' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700', 'px-4 py-1.5 text-sm font-medium rounded-md transition-all']">
                        Meetings
                    </button>
                </div>
            </div>
        </template>

        <!-- Main Content Area: Fills the remaining height -->
        <div class="h-[calc(100vh-14rem)] bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col mb-10">
            
            <!-- CHAT VIEW -->
            <div v-show="activeTab === 'chat'" class="flex flex-col h-full">
                <!-- Chat Header -->
                <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-white z-10">
                    <div class="flex items-center">
                        <div class="relative">
                            <div class="h-10 w-10 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold">
                                {{ currentContact.avatar }}
                            </div>
                            <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-growth-500 ring-2 ring-white"></span>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-gray-900">{{ currentContact.name }}</h3>
                            <p class="text-xs text-gray-500">{{ currentContact.role }}</p>
                        </div>
                    </div>
                    <button class="text-gray-400 hover:text-brand-600 transition-colors p-2 rounded-full hover:bg-brand-50" title="Schedule Meeting">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>

                <!-- Chat Messages Area -->
                <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-gray-50">
                    <div class="text-center">
                        <span class="text-xs font-medium text-gray-400 bg-gray-200 px-2 py-1 rounded-md">Today</span>
                    </div>

                    <div v-for="msg in messages" :key="msg.id" class="flex" :class="msg.sender === 'me' ? 'justify-end' : 'justify-start'">
                        <div class="flex max-w-lg items-end" :class="msg.sender === 'me' ? 'flex-row-reverse' : 'flex-row'">
                            <!-- Avatar -->
                            <div v-if="msg.sender === 'them'" class="h-8 w-8 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 text-xs font-bold flex-shrink-0 mb-1" :class="msg.sender === 'me' ? 'ml-2' : 'mr-2'">
                                {{ currentContact.avatar }}
                            </div>
                            
                            <!-- Bubble -->
                            <div class="flex flex-col space-y-1 text-sm" :class="msg.sender === 'me' ? 'items-end' : 'items-start'">
                                <div :class="[msg.sender === 'me' ? 'bg-brand-600 text-white rounded-l-2xl rounded-tr-2xl' : 'bg-white text-gray-800 border border-gray-200 shadow-sm rounded-r-2xl rounded-tl-2xl', 'px-4 py-2.5 max-w-sm break-words']">
                                    {{ msg.text }}
                                </div>
                                <span class="text-[10px] text-gray-400 font-medium px-1">{{ msg.time }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Input Area -->
                <div class="p-4 bg-white border-t border-gray-100">
                    <form @submit.prevent="sendMessage" class="flex items-center space-x-3">
                        <button type="button" class="text-gray-400 hover:text-gray-600 p-2">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                        </button>
                        <input type="text" v-model="messageText" placeholder="Type a message..." class="flex-1 block w-full rounded-full border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50 text-sm py-2.5 px-4 shadow-sm" />
                        <button type="submit" :disabled="!messageText.trim()" :class="[messageText.trim() ? 'bg-brand-600 hover:bg-brand-700 text-white shadow-sm' : 'bg-gray-100 text-gray-400 cursor-not-allowed', 'p-2.5 rounded-full transition-colors flex items-center justify-center']">
                            <svg class="h-5 w-5 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- MEETINGS VIEW -->
            <div v-show="activeTab === 'meetings'" class="flex flex-col h-full overflow-y-auto bg-gray-50 p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Your Schedule</h3>
                    <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                        Request Meeting
                    </button>
                </div>

                <div class="space-y-4">
                    <div v-for="meeting in meetings" :key="meeting.id" class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between hover:shadow-md transition-shadow group">
                        
                        <div class="flex items-start">
                            <!-- Icon/Calendar Date -->
                            <div class="h-12 w-12 rounded-lg border border-gray-200 bg-gray-50 flex flex-col items-center justify-center flex-shrink-0 mr-4">
                                <span class="text-[10px] font-bold text-brand-600 uppercase tracking-widest">{{ meeting.date.split(',')[0].split(' ')[0] || 'OCT' }}</span>
                                <span class="text-lg font-bold text-gray-900 leading-none">{{ meeting.date.match(/\d+/) ? meeting.date.match(/\d+/)[0] : '20' }}</span>
                            </div>
                            
                            <div>
                                <div class="flex items-center mb-1 space-x-2">
                                    <h4 class="text-base font-bold text-gray-900">{{ meeting.title }}</h4>
                                    <span :class="['px-2 py-0.5 inline-flex text-[10px] leading-4 font-semibold rounded-full border uppercase tracking-wider', getMeetingStatusColor(meeting.status)]">
                                        {{ meeting.status }}
                                    </span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 space-x-3">
                                    <span class="flex items-center">
                                        <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ meeting.date }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        With {{ meeting.with }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 sm:mt-0 flex items-center space-x-2 sm:ml-4">
                            <!-- Actions based on status -->
                            <template v-if="meeting.status === 'upcoming' && meeting.link">
                                <a :href="meeting.link" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-brand-600 hover:bg-brand-700">
                                    Join Link
                                </a>
                            </template>
                            
                            <template v-if="meeting.status === 'requested'">
                                <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                    Reschedule
                                </button>
                                <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-brand-600 hover:bg-brand-700">
                                    Accept
                                </button>
                            </template>

                            <template v-if="meeting.status === 'done'">
                                <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                    Leave Feedback
                                </button>
                            </template>
                            
                            <!-- Context Menu -->
                            <button class="text-gray-400 hover:text-gray-600 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </BreezeAuthenticatedLayout>
</template>

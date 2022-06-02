<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    type: '',
    phone: '',
    bio: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Register" />

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="name" value="Name" />
                <BreezeInput name ="name" id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="email" value="Email" />
                <BreezeInput name ="email" id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="Email" />
            </div>
  
            <div class="mt-4">
                <BreezeLabel for="type" value="Type" />
                <select name ="type" class="mt-1 block w-full" v-model="form.type"  type="select" id="type" required autocomplete="type"> 
                <option value="">Please Select Type</option>
                <option>Mentor</option> 
                <option>Mentee</option> 
                </select>
            </div>

             <div class="mt-4">
                <BreezeLabel for="phone" value="Phone" />
                <BreezeInput name ="phone" id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" required autocomplete="phone" />
            </div>

             <div class="mt-4">
                <BreezeLabel for="bio" value="Bio" />
                <BreezeInput name ="bio" id="bio" type="text" class="mt-1 block w-full" v-model="form.bio" required autocomplete="bio" />
            </div>


            <div class="mt-4">
                <BreezeLabel for="password" value="Password" />
                <BreezeInput name ="password" id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password_confirmation" value="Confirm Password" />
                <BreezeInput name ="password_confirmation" id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>


            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Already registered?
                </Link>

                <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>

<template>
    <div class="h-screen flex flex-wrap justify-center items-center">
        <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow font-Roboto sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
            <form class="space-y-6" @submit.prevent="authenticateUser">
                <h5 class="text-xl text-center font-medium text-gray-900 dark:text-white">Sign in to our platform</h5>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                    <input type="email" v-model="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                    <input type="password" v-model="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                </div>
                <button type="submit" class="w-full text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">Login to your account</button>
                <div class="text-sm text-center font-medium text-gray-500 dark:text-gray-300">
                    Not registered? <RouterLink to="signup" class="text-purple-700 hover:underline dark:text-purple-500">Create account</RouterLink>
                </div>
            </form>
        </div>
    </div>    
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useAuthStore } from '../store';
import {SignInPayload} from '../types' 

const email = ref('');
const password = ref('');

const store = useAuthStore();

const authenticateUser = () => {
    const payload: SignInPayload = {
        email: email.value,
        password: password.value,
    }
    store.signin(payload);
}
</script>
<template>
    <div class="h-screen flex flex-wrap justify-center items-center">
        <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow font-Roboto sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
            <form class="space-y-6" @submit.prevent="signUpUser">
                <h5 class="text-xl text-center font-medium text-gray-900 dark:text-white">Create your account</h5>
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
                    <input type="text" v-model="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="type your name" required>
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                    <input type="email" v-model="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                    <input type="password" v-model="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                    <input type="password" v-model="password2" id="password2" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                </div>
                <button type="submit" class="w-full text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">Register</button>
                <div class="text-sm text-center font-medium text-gray-500 dark:text-gray-300">
                    Already registered? <RouterLink to="signin" class="text-purple-700 hover:underline dark:text-purple-500">Signin here</RouterLink>
                </div>
            </form>
        </div>
    </div>
    
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter, RouterLink } from 'vue-router';
import { useFlash } from '../common/useFlash';
import Api from '../apis';

const name = ref(null);
const email = ref(null);
const password = ref(null);
const password2 = ref(null);

const router = useRouter();
const { flash } = useFlash();

const signUpUser = () => {
    let errorStatus = '';
    let payload = {
        'name': name.value,
        'email': email.value,
        'password': password.value
    }
    Api.post('signup', payload)
    .then((response) => {
        let result = response.data;
        console.log(result);
        if (! result.error) {            
            flash({
                iconType: "success",
                title: "Registration Completed",
                message: result.message
            });
            setTimeout(()=>{
                router.push('signin');
            }, 2000);
        } else {
            flash({
                iconType: "error",
                title: "Registration Error",
                message: result.message
            });
        }
    }).catch(error => {
        if (!error.response) {
            errorStatus = 'Error: Network Error';
        } else {
            errorStatus = error.response.data.message;
        }
        flash({
            iconType: "error",
            title: "Registration Error",
            message: errorStatus
        });
    })
}
</script>
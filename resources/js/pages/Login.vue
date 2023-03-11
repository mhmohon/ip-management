<template>
    <div class="mx-auto w-full sm:w-6/12 mt-10 bg-gray-700 p-4 rounded-lg">
        <!-- component -->
        <div
            class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col"
        >
            <h1 class="text-gray-600 py-5 font-bold text-3xl"> Login </h1>
            <div v-if="typeof errors == 'object'">
                <p class="list-disc text-red-400 pb-5">{{ errors[0][0] }}</p>
            </div>
            <p class="list-disc text-red-400 pb-5" v-if="typeof errors === 'string'">{{errors}}</p>
            <form method="post" @submit.prevent="handleLogin">
            <div class="mb-4">
                <label
                    class="block text-grey-darker text-sm font-bold mb-2"
                    for="email"
                >
                    Email Address
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                    id="email"
                    type="text"
                    v-model="form.email"
                    required
                />
            </div>
            <div class="mb-4">
                <label
                    class="block text-grey-darker text-sm font-bold mb-2"
                    for="password"
                >
                    Password
                </label>
                <input
                    class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3"
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                />
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="bg-sky-500 hover:bg-sky-900 text-white font-bold py-2 px-4 rounded"
                    type="submit"
                >
                    Sign In
                </button>
            </div>
        </form>
        <div class="flex items-center mt-10">
            <button
                class="bg-sky-900 text-white font-bold py-2 px-4 mr-5 rounded"
                @click="fillInCredentials1"
            >
                User A
            </button>
            <button
                class="bg-sky-900 text-white font-bold py-2 px-4 rounded"
                @click="fillInCredentials2"
            >
                User B
            </button>
        </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref } from 'vue';
import axios from 'axios';
import {useRouter} from "vue-router";
export default {
    setup() {
        const errors = ref()
        const router = useRouter();
        const form = reactive({
            email: '',
            password: '',
        })
        const fillInCredentials1 = () => {
            form.email = 'mhmosharrf@gmail.com';
            form.password = 'password';
        };
        const fillInCredentials2 = () => {
            form.email = 'dummyuser@gmail.com';
            form.password = 'password';
        };
        const handleLogin = async () => {
            try {
                const result = await axios.post('/api/login', form)
                if (result.status === 200 && result.data.payload && result.data.payload.token) {
                    localStorage.setItem('APP_USER_TOKEN', result.data.payload.token)
                    await router.push('home')
                }
            } catch (e) {
                if(e && e.response.data && e.response.data.errors) {
                    errors.value = Object.values(e.response.data.errors)
                } else {
                    errors.value = e.response.data.message || ""
                }
            }
        }
        return {
            form,
            errors,
            fillInCredentials1,
            fillInCredentials2,
            handleLogin,
        }
    }
}
</script>

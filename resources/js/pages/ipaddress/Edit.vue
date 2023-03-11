<template>
    <Navbar />
    <div class="w-6/12 p-10 mx-auto">
        <div class="flex justify-between">
            <h1 class="text-2xl"> Edit IP Addresses </h1>
            <router-link class="bg-sky-500 hover:bg-sky-900 text-white py-2 px-4 rounded" :to="{name: 'home'}">Back</router-link>
        </div>
        <div class="mx-auto mt-10 bg-gray-100 p-2 rounded-lg">
        <!-- component -->
            <div
                class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col"
            >
                <div v-if="typeof errors == 'object'">
                    <p class="list-disc text-red-400 pb-5">{{ errors[0][0] }}</p>
                </div>
                <p class="list-disc text-red-400 pb-5" v-if="typeof errors === 'string'">{{errors}}</p>
                <form method="post" @submit.prevent="handleEdit">
                <div class="mb-4">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="label"
                    >
                        IP Label
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                        id="label"
                        type="text"
                        v-model="form.label"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="ip_address"
                    >
                        IP Address
                    </label>
                    <input
                        class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3"
                        id="ip_address"
                        type="text"
                        v-model="form.ip_address"
                        :disabled=true
                    />
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-sky-500 hover:bg-sky-900 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                        type="submit"
                    >
                        Update
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import {ref, reactive, onMounted} from 'vue'
import {useRouter, useRoute} from "vue-router";
import Navbar from '../../components/Navbar.vue';
import {request} from '../../helper'

export default {
    setup() {
        const errors = ref()
        const router = useRouter();
        const route = useRoute();
        const isLoading = ref();
        const ID = route.params.id;
        const form = reactive({
            label: '',
        });
        onMounted(() => {
            handleFetch()
        });
        const handleFetch = async () => {
            try {
                const req = await request("get", `/api/ip-address/${ID}`, form)
                if (req.status === 200 && req.data.success == true) {
                    form.label = req.data.payload.label
                    form.ip_address = req.data.payload.ip_address
                }
            } catch (e) {
                await router.push({ name: 'home' })
            }
        }
        const handleEdit = async () => {
            try {
                const req = await request("put", `/api/ip-address/${ID}`, form)
                if (req.status === 200 && req.data.success == true) {
                    await router.push({ name: 'home' })
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
            isLoading,
            form,
            errors,
            handleEdit,
        };
    },
    components: { Navbar }
}
</script>

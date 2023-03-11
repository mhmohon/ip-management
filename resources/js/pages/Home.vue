<template>
    <Navbar />
    <div class="w-8/12 p-10 mx-auto">
        <div class="flex justify-between">
            <h1 class="text-2xl"> IP Addresses </h1>
            <router-link class="bg-sky-500 hover:bg-sky-900 text-white py-2 px-4 rounded" :to="{ name: 'ip.create' }">Create</router-link>
        </div>
        <div class="flex flex-col mt-10">
            <div class="overflow-x-auto">
                <div class="p-1.5 w-full inline-block align-middle">
                    <div class="overflow-hidden border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                        Label
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                        IP Address
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                        Created
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-bold text-right text-gray-500 uppercase">
                                        Edit
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-if="ipAddresses.length === 0">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">No record found</td>
                                </tr>
                                <tr v-else v-for="(val, idx) in ipAddresses" :key="idx">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">{{ number++ }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ val.label }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ val.ip_address }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ val.created_at }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <router-link class="text-green-500 hover:text-green-700" :to="{name: 'ip.edit', params: { id: val.id }}">Edit
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Loader class="pl-10" v-if="isLoading"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {ref, onMounted} from 'vue'
import {useRouter} from "vue-router";
import {request} from '../helper'
import Loader from '../components/Loader.vue';
import Navbar from '../components/Navbar.vue';

export default {
    components: {
        Loader,
        Navbar
    },
    setup() {
        const ipAddresses = ref([])
        const user = ref()
        const isLoading = ref()
        let number = 1

        let router = useRouter();
        onMounted(() => {
            authentication()
            handleIpAddresses()
        });

        const authentication = async () => {
            isLoading.value = true
            try {
                const req = await request('get', '/api/user')
                user.value = req.data
            } catch (e) {
                await router.push('/')
            }
        }

        const handleIpAddresses = async () => {
            try {
                const req = await request('get', '/api/ip-address')
                ipAddresses.value = req.data.payload.data
            } catch (e) {
                await router.push('/')
            }
            isLoading.value = false
        }

        return {
            ipAddresses,
            user,
            isLoading,
            number,
        }
    },
}
</script>

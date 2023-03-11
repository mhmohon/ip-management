<template>
    <Navbar />
    <div class="w-8/12 p-10 mx-auto">
        <div class="flex justify-between">
            <h1 class="text-2xl"> Audit Logs </h1>
        </div>
        <div class="flex flex-col mt-10">
            <div class="overflow-x-auto">
                <div class="p-1.5 w-full inline-block align-middle">
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                        ID
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                        Created At
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                        Event
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                        Description
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                        Properties
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="(val, idx) in auditLogs" :key="idx">
                                    <td class="px-3 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">{{ number++ }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-800 whitespace-nowrap">{{ val.created_at }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-800 whitespace-nowrap">{{ val.event }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-800 whitespace-nowrap">{{ val.description }} </td>
                                    <td class="px-3 py-4 text-sm text-gray-800 whitespace-nowrap">{{ val.properties }}</td>
                                    
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
<!-- https://www.tutsmake.com/laravel-9-vue-js-crud-example-tutorial/ -->
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
        const auditLogs = ref([])
        const user = ref()
        const isLoading = ref()
        let number = 1

        let router = useRouter();
        onMounted(() => {
            authentication()
            handleAuditLogs()
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

        const handleAuditLogs = async () => {
            try {
                const req = await request('get', '/api/auditlogs')
                auditLogs.value = req.data.payload.data
            } catch (e) {
                await router.push('/')
            }
            isLoading.value = false
        }
        return {
            auditLogs,
            user,
            isLoading,
            number
        }
    },
}
</script>

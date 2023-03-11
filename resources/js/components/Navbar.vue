<template>
    <div class="mx-auto">
        <nav class="bg-gray-800 px-6 py-4">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-4 flex flex-col container mx-auto md:flex-row md:items-center md:justify-between">
                <div class="flex justify-between items-center pl-5">
                    <div>
                        <a class="text-blue-500 md:text-2xl" href="#">IP <span class="text-white text-xl font-bold md:text-xl">Management</span></a>
                    </div>
                    <div>
                        <button type="button" @click="isOpen = !isOpen" class="block text-gray-800 hover:text-gray-600 focus:text-gray-600 focus:outline-none md:hidden">
                            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                                <path d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex flex-col pr-5 md:flex-row md:-mx-4" :class="isOpen ? 'block' : ['hidden' , 'md:block']">
                    <router-link class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium" to="/home">Home</router-link>
                    <router-link class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium" to="/auditlogs">AuditLogs</router-link>
                    <button @click="handleLogout" class="text-gray-300 ml-4 px-3 py-2 rounded-md text-sm font-medium hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Logout</button>
                </div>
            </div>
        </nav>
    </div>
</template>
<script>
import {useRouter} from "vue-router";
import {request} from '../helper'

export default {
    data() {
        return {
            isOpen: false
        }
    },
    setup() {
        let router = useRouter();

        const handleLogout = async () => {
            try {
                const req = await request("post", "/api/logout", [])
                if (req.status === 200 && req.data.success == true) {
                    localStorage.removeItem('APP_USER_TOKEN')
                    await router.push({ name: 'login' })
                }
            } catch (e) {
                await router.push('/')
            }
        }
        return {
            handleLogout,
        }
    },
}
</script>
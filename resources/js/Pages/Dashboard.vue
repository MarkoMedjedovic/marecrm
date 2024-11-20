<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
 
 
                    <Link
                        :href="route('customers.index')"
                        class="float-start inline-flex my-1 text-indigo-800 font-bold bg-white-500 border-0 py-1 px-0 focus:outline-none hover:bg-silver-600 rounded"
                        >View all clients</Link
                    >

                    <Link
                        :href="route('purchases.index')"
                        class="ml-4 float-start inline-flex my-1 text-indigo-800 font-bold bg-white-500 border-0 py-1 px-0 focus:outline-none hover:bg-silver-600 rounded"
                        >View report</Link
                    >

                    <Link
                        :href="route('logout')"  
                        method="post"
                        as="button"
                        class="ml-4 float-start inline-flex my-1 text-indigo-800 font-bold bg-white-500 border-0 py-1 px-0 focus:outline-none hover:bg-silver-600 rounded"
                        >Logout</Link
                    >
 
        </template>



        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
 
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

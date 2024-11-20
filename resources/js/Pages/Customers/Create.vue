<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Core as YubinBangoCore } from "yubinbango-core2";

defineProps({
    errors: Object,
});

const form = reactive({
    firstName: null,
    lastName: null,
    tel: null,
    email: null,
    postcode: null,
    address: null,
    birthday: null,
    gender: null,
    memo: null,
    hasCashLoan: false,
    hasHomeLoan: false,
});

const fetchAddress = () => {
    new YubinBangoCore(String(form.postcode), (value) => {
        form.address = value.region + value.locality + value.street;
    });
};

const storeCustomer = () => {
    router.post(route("customers.store"), form);
};
</script>

<template>
    <Head title="Customer Registration" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customer Registration
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <BreezeValidationErrors :errors="errors" />
                            <form @submit.prevent="storeCustomer">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="firstName"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >First Name</label
                                                    >
                                                    <input
                                                        type="text"
                                                        id="firstName"
                                                        name="firstName"
                                                        v-model="form.firstName"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="lastName"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Last name</label
                                                    >
                                                    <input
                                                        type="text"
                                                        id="lastName"
                                                        name="lastName"
                                                        v-model="form.lastName"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="tel"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Phone number</label
                                                    >
                                                    <input
                                                        type="text"
                                                        id="tel"
                                                        name="tel"
                                                        v-model="form.tel"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="email"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Email address</label
                                                    >
                                                    <input
                                                        type="text"
                                                        id="email"
                                                        name="email"
                                                        v-model="form.email"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="postcode"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Postal code</label
                                                    >
                                                    <input
                                                        type="text"
                                                        id="postcode"
                                                        name="postcode"
                                                        @change="fetchAddress"
                                                        v-model="form.postcode"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="address"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Address</label
                                                    >
                                                    <input
                                                        type="text"
                                                        id="address"
                                                        name="address"
                                                        v-model="form.address"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="birthday"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Birthday</label
                                                    >
                                                    <input
                                                        type="date"
                                                        id="birthday"
                                                        name="birthday"
                                                        v-model="form.birthday"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="gender"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Gender: </label
                                                    >
                                                    <input
                                                        type="radio"
                                                        id="gender0"
                                                        name="gender0"
                                                        v-model="form.gender"
                                                        value="0"
                                                    />
                                                    <label
                                                        for="gender0"
                                                        class="ml-2 mr-2"
                                                        >Male</label
                                                    >
                                                    <input
                                                        type="radio"
                                                        id="gender1"
                                                        name="gender1"
                                                        v-model="form.gender"
                                                        value="1"
                                                    />
                                                    <label
                                                        for="gender1"
                                                        class="ml-2 mr-2"
                                                        >Female</label
                                                    >

                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="memo"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Note</label
                                                    >
                                                    <textarea
                                                        id="memo"
                                                        name="memo"
                                                        v-model="form.memo"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                                                    ></textarea>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <button
                                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                                >
                                                    Create
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
 


    </AuthenticatedLayout>
</template>

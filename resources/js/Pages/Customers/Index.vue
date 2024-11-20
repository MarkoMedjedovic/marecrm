<script setup>
import FlashMessage from "@/Components/FlashMessage.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";

defineProps({
    customers: Object,
});

const deleteCustomer = (id) => {
    router.delete(route("customers.destroy", { customer: id }), {
        onBefore: () => confirm("Are you sure you want to delete？"),
    });
};

const search = ref("");

const searchCustomers = () => {
    router.get(route("customers.index", { search: search.value }));
};
</script>

<template>
    <Head title="Customer List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customer List
            </h2>
            <!--Link
                as="button"
                :href="route('dashboard')"
                class="float-start flex my-1 text-indigo-800 font-bold bg-white-500 border-0 py-1 px-0 focus:outline-none hover:bg-silver-600 rounded"
            >
            Go back to dashboard
            </Link-->
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-8 mx-auto">
                                <FlashMessage />
                                <div
                                    class="lg:w-4/5 w-full mx-auto overflow-auto"
                                >
                                    <div>
                                        <input
                                            type="text"
                                            name="search"
                                            v-model="search"
                                        />
                                        <button
                                            class="bg-blue-300 text-white py-2 px-2"
                                            @click="searchCustomers"
                                        >
                                            Search customers
                                        </button>
                                    </div>
                                    <Link
                                        as="button"
                                        :href="route('customers.create')"
                                        class="flex ml-auto my-4 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                                    >
                                        Customer Registration
                                    </Link>

                                    <table
                                        class="table-auto w-full text-left whitespace-no-wrap"
                                    >
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                                >
                                                    Id
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >
                                                    Full name
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >
                                                    Email, phone
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >
                                                    Has cash loan
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >
                                                    Has home loan
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >
                                                    Edit
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >
                                                    Delete
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="customer in customers.data"
                                                :key="customer.id"
                                            >
                                                <td
                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    {{ customer.id }}
                                                </td>
                                                <td
                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    {{ customer.first_name }} {{ customer.last_name }}
                                                </td>
                                                <td
                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    {{ customer.email }},
                                                    <br>{{ customer.tel }}
                                                </td>
                                                <td
                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    <span v-if="customer.has_cash_loan == 0">
                                                        no
                                                    </span>
                                                    <span v-else>
                                                        yes
                                                    </span>
                                                </td>
                                                <td
                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    <span v-if="customer.has_home_loan == 0">
                                                        no
                                                    </span>
                                                    <span v-else>
                                                        yes
                                                    </span>
                                                </td>
                                                <td
                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    <Link
                                                        as="button"
                                                        :href="route('customers.edit',{ customer: customer.id })"
                                                        class="flex ml-auto my-4 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                                                    >
                                                        Edit
                                                    </Link>
                                                </td>
                                                <td
                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    <button
                                                        @click="deleteCustomer(customer.id)"
                                                        class="flex ml-auto my-4 text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                                                    >
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div
                                    class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto"
                                ></div>
                            </div>
                            <Pagination
                                class="mt-6"
                                :links="customers.links"
                            ></Pagination>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

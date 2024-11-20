<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { nl2br } from "@/common";

defineProps({
    item: Object,
});

const deleteItem = (id) => {
    router.delete(route("items.destroy", { item: id }), {
        onBefore: () => confirm("Are you sure you want to delete？"),
    });
};
</script>

<template>
    <Head title="Product details" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Product details
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-8 mx-auto">
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label
                                                    for="name"
                                                    class="leading-7 text-sm text-gray-600"
                                                    >Product</label
                                                >
                                                <div
                                                    id="name"
                                                    class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                >
                                                    {{ item.name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label
                                                    for="memo"
                                                    class="leading-7 text-sm text-gray-600"
                                                    >Note</label
                                                >
                                                <div
                                                    id="memo"
                                                    style="
                                                        white-space: pre-wrap;
                                                    "
                                                    v-text="item.memo"
                                                    class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                                                ></div>
                                            </div>
                                        </div>

                                        <div v-if="item.type === 'cash'"  class="p-2 ">
                                                <div class="relative">
                                                    <label
                                                        for="type1"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Loan type: </label
                                                    >
                                                    <input
                                                        type="radio"
                                                        id="type1"
                                                        name="type"
                                                        value="cash"
                                                        v-model="item.type"
                                                    />
                                                    <label
                                                        for="type1"
                                                        class="ml-2 mr-4"
                                                        > Cash loan</label
                                                    >
                                                </div>
                                            </div>

                                        <div v-if="item.type === 'home'"  class="p-2 ">
                                                <div class="relative">
                                                    <input
                                                        type="radio"
                                                        id="type2"
                                                        name="type"
                                                        value="home"
                                                        v-model="item.type"
                                                    />
                                                    <label
                                                        for="type2"
                                                        class="ml-2 mr-4"
                                                        > Home loan</label
                                                    >
                                                </div>
                                            </div>
 
                                            <div v-if="item.type === 'cash'" class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="loanAmount"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Loan amount</label
                                                    >
                                                    <input
                                                        type="number"
                                                        id="loanAmount"
                                                        name="loanAmount"
                                                        v-model="item.loan_amount"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>


                                            <div v-if="item.type === 'home'" class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="propertyValue"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Property value</label
                                                    >
                                                    <input
                                                        type="number"
                                                        id="propertyValue"
                                                        name="propertyValue"
                                                        v-model="item.property_value"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>

                                            <div v-if="item.type === 'home'" class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="downPayment"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Down payment</label
                                                    >
                                                    <input
                                                        type="number"
                                                        id="downPayment"
                                                        name="downPayment"
                                                        v-model="item.down_payment"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                         

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    Price: {{ item.price }}
                                                </div>
                                            </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <div
                                                    id="status"
                                                    class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                >
                                                    <span
                                                        v-if="
                                                            item.is_selling ===
                                                            1
                                                        "
                                                    >
                                                        Available now
                                                    </span>
                                                    <span
                                                        v-if="
                                                            item.is_selling ===
                                                            0
                                                        "
                                                    >
                                                        停止中
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <Link
                                                as="button"
                                                :href="
                                                    route('items.edit', {
                                                        item: item.id,
                                                    })
                                                "
                                                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                            >
                                                Edit
                                            </Link>
                                        </div>

                                        <div class="mt-20 p-2 w-full">
                                            <button
                                                @click="deleteItem(item.id)"
                                                class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

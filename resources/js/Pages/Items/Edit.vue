<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { reactive, watch } from "vue";

const props = defineProps({
    item: Object,
});

const form = reactive({
    id: props.item.id,
    name: props.item.name,
    memo: props.item.memo,
    type: props.item.type,
    loanAmount: props.item.loan_amount,
    propertyValue: props.item.property_value,
    downPayment: props.item.down_payment,
    price: props.item.price,
    //is_selling: (props.is_selling === null) ? 1 : props.is_selling,
    is_selling: 1,
});

const updateItem = (id) => {
    if (form.type == 'cash') {
        form.propertyValue = 0;
        form.downPayment = 0;
    } else if (form.type == 'home') {
        form.loanAmount = 0;
    }
    router.put(route("items.update", { item: id }), form);
};

watch(
    () => {
        if (form.type == 'cash') {
            form.price = form.loanAmount;
        } else if (form.type == 'home') {
            form.price = form.propertyValue - form.downPayment;
        }
    }
);

</script>

<template>
    <Head title="Edit" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="updateItem(form.id)">
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
                                                    <input
                                                        type="text"
                                                        id="name"
                                                        name="name"
                                                        v-model="form.name"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
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
                                            <div class="p-2 ">
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
                                                        value="cash" checked 
                                                        v-model="form.type"
                                                    />
                                                    <label
                                                        for="type1"
                                                        class="ml-2 mr-4"
                                                        > Cash loan</label
                                                    >
                                                </div>
                                            </div>

                                            <div class="p-2 ">
                                                <div class="relative">
                                                    <input
                                                        type="radio"
                                                        id="type2"
                                                        name="type"
                                                        value="home"
                                                        v-model="form.type"
                                                    />
                                                    <label
                                                        for="type2"
                                                        class="ml-2 mr-4"
                                                        > Home loan</label
                                                    >
                                                </div>
                                            </div>
 
                                            <div v-if="form.type === 'cash'" class="p-2 w-full">
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
                                                        v-model="form.loanAmount"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>


                                            <div v-if="form.type === 'home'" class="p-2 w-full">
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
                                                        v-model="form.propertyValue"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>

                                            <div v-if="form.type === 'home'" class="p-2 w-full">
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
                                                        v-model="form.downPayment"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    />
                                                </div>
                                            </div>
                                         

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    Price: {{ form.price }}
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="is_selling"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >Status: </label
                                                    >
                                                    <input
                                                        type="radio"
                                                        id="is_selling"
                                                        name="is_selling"
                                                        v-model="
                                                            form.is_selling
                                                        "
                                                        value="1"
                                                    />
                                                    <label class="ml-2 mr-4"
                                                        >Available now</label
                                                    >
                                                    <input
                                                        type="radio"
                                                        id="is_selling"
                                                        name="is_selling"
                                                        v-model="
                                                            form.is_selling
                                                        "
                                                        value="0"
                                                    />
                                                    <label class="ml-2 mr-4"
                                                        >Not available</label
                                                    >
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <button
                                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                                >
                                                    Update
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

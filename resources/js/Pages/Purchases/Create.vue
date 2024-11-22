<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { onMounted, reactive, ref, computed, watch } from "vue";
import { router } from "@inertiajs/vue3";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { getToday } from "@/common";
import MicroModal from "@/Components/MicroMordal.vue";
import StorePurchaseComponent from "./StorePurchaseComponent.vue";


// Loan editor stuff :
const props = defineProps({
    customers: Array,
    items: Array,
    errors: Object
});

const itemList = ref([]);

watch(
    () => {
        itemList.value.forEach((item) => {
            if (item.type == 'cash') {
                item.price = item.loan_amount;
            } else if (item.type == 'home') {
                item.price = item.property_value - item.down_payment;
            }

        });
    }
);


onMounted(() => {

    let params = new URLSearchParams(window.location.search);
    let url_cid = params.get('cid');
    let url_cname = params.get('cname');
    if (url_cid !== null) {
        form.customer_id = url_cid;
        form.customer_name = url_cname;
    }

    console.log(props.items);

    form.date = getToday();

    props.items.forEach((item) => {
        itemList.value.push({
            id: item.id,
            name: item.name,
            price: item.price,

            type: item.type,
            loan_amount: item.loan_amount,
            property_value: item.property_value,
            down_payment: item.down_payment,

            quantity: 1,
            user_id: item.user_id,
        });
    });
});

const form = reactive({
    date: null,
    customer_id: null,
    customer_name: null,
    status: true,
    items: [],
});

const totalPrice = computed(() => {
    let total = 0;
    itemList.value.forEach((item) => {
        total += item.price * item.quantity;
    });
    return total;
});

const storePurchase = async () => {
    console.log(itemList);
    itemList.value.forEach((item) => {
        //if (item.quantity != '0') { //neka se kreiraju oba proizvoda za datog clijenta
        form.items.push({
            id: item.id,
            type: item.type,
            quantity: item.quantity,
            loan_amount: item.loan_amount,
            property_value: item.property_value,
            down_payment: item.down_payment,
            price: item.price,
            user_id: item.user_id
        });
        //}
    });
    let feedback = router.post(route("purchases.store"), form);
    console.log(feedback);
};

const setCustomerId = (id) => {
    //console.log(id);
    let myArray = id.split("_");
    let cid__ = myArray[0];
    let cname__ = myArray[1];
    form.customer_id = cid__;
    //form.customer_name = cname__;

    router.get('/purchases/create' + '?cid=' + cid__ + '&cname=' + cname__);
};

const quantity = [/*"0",*/ "1" /*, "2", "3", "4", "5", "6", "7", "8", "9"*/];
</script>

<template>

    <Head title="Purchase Registration" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Purchase Registration/Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">

                            <BreezeValidationErrors :errors="errors" />

                            <form @submit.prevent="storePurchase">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-4/5 md:w-2/3 mx-auto">

                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="date"
                                                        class="leading-7 text-sm text-gray-600">Date</label>
                                                    <input type="date" id="date" name="date" v-model="form.date"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                                </div>

                                                <div class="relative">
                                                    <label for="customer" class="leading-7 text-sm text-gray-600">Member
                                                        Name</label>
                                                    <MicroModal @update:customer-id="setCustomerId
                                                        " />
                                                </div>
                                            </div>


                                            <StorePurchaseComponent
                                             :itemList="itemList" 
                                             :totalPrice="totalPrice"
                                             />
 
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

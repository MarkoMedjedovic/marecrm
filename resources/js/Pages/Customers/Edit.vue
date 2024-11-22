<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
//import { reactive, watch } from "vue";
import { onMounted, reactive, watch, ref, computed } from "vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { getToday } from "@/common";
import StorePurchaseComponent from "../Purchases/StorePurchaseComponent.vue";


const props = defineProps({
    customer: Object,
    itemsZero: Array,
    items: Array,
    purchases: Array,
    errors: Object
});

const form = reactive({
    id: props.customer.id,
    firstName: props.customer.first_name,
    lastName: props.customer.last_name,
    tel: props.customer.tel,
    email: props.customer.email,
    postcode: props.customer.postcode,
    address: props.customer.address,
    birthday: props.customer.birthday,
    gender: props.customer.gender,
    memo: props.customer.memo,
    hasCashLoan: props.customer.has_cash_loan,
    hasHomeLoan: props.customer.has_home_loan,

    date: null,
    customer_id: props.customer.id,
    status: true,
    items: [],
    itemList2: props.items
});

const updateCustomer = (id) => {
    router.put(route("customers.update", { customer: id }), form);
};

const goLoans = () => {

    router.get('/purchases/create' + '?cid=' + form.id + '&cname=' + form.firstName + ' ' + form.lastName);
};

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
    form.date = getToday();
    let takeItems = props.items;

    if(props.items==null || props.items.length==0){
        takeItems = props.itemsZero;
    }
    takeItems.forEach((item) => {
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
    console.log('Purchases by Customer id:');
    console.log(props.purchases);
});

const totalPrice = computed(() => {
    let total = 0;
    itemList.value.forEach((item) => {
        total += item.price * item.quantity; //?? =0
    });

    //console.log('totalPrice form.. ' +JSON.stringify(itemList));
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


const quantity = [/*"0",*/ "1" /*, "2", "3", "4", "5", "6", "7", "8", "9"*/];

</script>

<template>

    <Head title="Customer Edit" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customer Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <BreezeValidationErrors :errors="errors" />
                            <form @submit.prevent="updateCustomer(form.id)">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="firstName" class="leading-7 text-sm text-gray-600">First
                                                        name</label>
                                                    <input type="text" id="firstName" name="firstName"
                                                        v-model="form.firstName"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="lastName" class="leading-7 text-sm text-gray-600">Last
                                                        name</label>
                                                    <input type="text" id="lastName" name="lastName"
                                                        v-model="form.lastName"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="tel" class="leading-7 text-sm text-gray-600">Phone
                                                        number</label>
                                                    <input type="text" id="tel" name="tel" v-model="form.tel"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="email" class="leading-7 text-sm text-gray-600">Email
                                                        address</label>
                                                    <input type="text" id="email" name="email" v-model="form.email"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="postcode" class="leading-7 text-sm text-gray-600">Postal
                                                        code</label>
                                                    <input type="text" id="postcode" name="postcode"
                                                        @change="fetchAddress" v-model="form.postcode"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="address"
                                                        class="leading-7 text-sm text-gray-600">Address</label>
                                                    <input type="text" id="address" name="address"
                                                        v-model="form.address"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="birthday"
                                                        class="leading-7 text-sm text-gray-600">Birthday</label>
                                                    <input type="date" id="birthday" name="birthday"
                                                        v-model="form.birthday"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="gender" class="leading-7 text-sm text-gray-600">Gender:
                                                    </label>
                                                    <input type="radio" id="gender0" name="gender0"
                                                        v-model="form.gender" value="0" />
                                                    <label for="gender0" class="ml-2 mr-2">Male</label>
                                                    <input type="radio" id="gender1" name="gender1"
                                                        v-model="form.gender" value="1" />
                                                    <label for="gender1" class="ml-2 mr-2">Female</label>

                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="memo"
                                                        class="leading-7 text-sm text-gray-600">Note</label>
                                                    <textarea id="memo" name="memo" v-model="form.memo"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <button
                                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                                                    Save
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!--div class="p-2 w-full">
                                <button
                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                    @click="goLoans">
                                    Add/Edit Loans
                                </button>
                            </div-->

                            <BreezeValidationErrors :errors="errors" />
                            <form @submit.prevent="storePurchase">
                                <StorePurchaseComponent
                                                :itemList="itemList" 
                                                :totalPrice="totalPrice"
                                                />
                            </form>

                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

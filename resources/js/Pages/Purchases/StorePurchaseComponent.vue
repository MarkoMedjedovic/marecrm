<script setup>
const props = defineProps({
    itemList: Object,
    totalPrice: Number
});
</script>

<template>
    <!-- StorePurchaseComponent -->
    <div class="p-2 w-full">
        <table class="table-auto w-full text-left whitespace-no-wrap">
            <thead>
                <tr>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                        Id
                    </th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        Product
                    </th>

                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        Loan amount
                    </th>


                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        Property value
                    </th>


                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        Down payment
                    </th>

                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        Price
                    </th>

                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        Quantity
                    </th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                        Subtotal
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in itemList" :key="item.id">
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ item.id }}
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ item.name }}
                    </td>


                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        <input type="number" id="loan_amount" name="loan_amount" v-model="item.loan_amount"
                            :disabled="(item.type == 'home')"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        <input type="number" id="property_value" name="property_value" v-model="item.property_value"
                            :disabled="(item.type == 'cash')"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        <input type="number" id="down_payment" name="down_payment" v-model="item.down_payment"
                            :disabled="(item.type == 'cash')"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                    </td>

                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        €{{ item.price }}
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        <select name="quantity" v-model="item.quantity
                            ">
                            <option v-for="q in quantity" :value="q
                                ">
                                {{ q }}
                            </option>
                        </select>
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        €{{
                            item.price *
                            item.quantity
                        }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="p-2 w-full">
        <div class="">
            <label for="" class="">Total Amount</label>
            <div
                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                €{{ totalPrice }}
                <div></div>
            </div>

            <div class="p-2 w-full">
                <button
                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                    Register
                </button>
            </div>
        </div>
    </div>
    <!-- End StorePurchaseComponent -->

</template>
<script setup>
import dayjs from "dayjs";
import { onMounted, reactive  } from "vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";

const props = defineProps({
    orders: Object,
});

/*onMounted(() => {
    console.log(' orders: '+ JSON.stringify(props.orders));
});*/

const advisersFilter = ref(1);

const search = ref("");

const searchPurchasesByCustomer = () => {
    router.get(route("purchases.index", 
    { advisersFilter: advisersFilter.value,
        search: search.value, 
     }));
};

onMounted(() => { 
    let params = new URLSearchParams(window.location.search);
    let url_advisersFilter = params.get('advisersFilter');
    let url_search = params.get('search');
    if(url_advisersFilter!==null){
        advisersFilter.value = url_advisersFilter;
    }
    if(url_search!==null){
        search.value = url_search;
    }
});

</script>



<template>
    <Head title="Purchase history" />
 
 
    <AuthenticatedLayout>
        <template #header>
            <h2 class="inline-block font-semibold text-xl text-gray-800 leading-tight">
                Purchase history
            </h2>
 
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-8 mx-auto">
                                <FlashMessage />
                                <div
                                    class="lg:w-2/3 w-full mx-auto overflow-auto"
                                >
                                    <div class="content-center">
                                        <div >
                                                Advisers:
                                                <label class="ml-7 inline"  for="one">One</label>
                                                <input class="ml-1 inline" type="radio" name="advisersFilter" id="one" :value="1" v-model="advisersFilter" 
                                                />
                                                <label class="ml-4 inline" for="all">All</label>
                                                <input class="ml-1 inline" type="radio" name="advisersFilter" id="all" :value="2" v-model="advisersFilter"
                                                />

                                                <input class="ml-7 ml-1 inline" 
                                                    type="text"
                                                    name="search"
                                                    v-model="search"
                                                    placeholder="Customer name"
                                                />
                                                <button
                                                    class="ml-7 bg-blue-300 text-white py-2 px-6"
                                                    @click="searchPurchasesByCustomer"
                                                >
                                                    Search
                                                </button>
                                        </div>
                                     </div><br>

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
                                                    Customer name
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >
                                                    Total Amount
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >
                                                    Adviser name
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >
                                                    Purchase Date
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="order in props.orders
                                                    .data"
                                                :key="order.id"
                                            >
                                                <td
                                                    class="text-blue-800 border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    <Link
                                                        :href="`/purchases/create?cid=${order.customer_id}&cname=${order.customer_name}`"

                                                        >{{ order.id }}</Link
                                                    >
                                                </td>
                                                <td
                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    {{ order.customer_name }}
                                                </td>
                                                <td
                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    {{ order.total }}
                                                </td>
                                                <td
                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    {{ order.adviser_name }}
                                                </td>
                                                <td
                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                >
                                                    {{
                                                        dayjs(
                                                            order.created_at
                                                        ).format(
                                                            "YYYY-MM-DD HH:mm:ss"
                                                        )
                                                    }}
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
                                :links="props.orders.links"
                            ></Pagination>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

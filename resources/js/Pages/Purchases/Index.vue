<script setup>
import dayjs from "dayjs";
import { onMounted, reactive } from "vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
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
        {
            advisersFilter: advisersFilter.value,
            search: search.value,
        }));
};

onMounted(() => {
    let params = new URLSearchParams(window.location.search);
    let url_advisersFilter = params.get('advisersFilter');
    let url_search = params.get('search');
    if (url_advisersFilter !== null) {
        advisersFilter.value = url_advisersFilter;
    }
    if (url_search !== null) {
        search.value = url_search;
    }
});

function jsonToCsv(jsonData) {
    let csv = '';
    
    // Extract headers
    const headers = Object.keys(jsonData[0]);
    csv += headers.join(',') + '\n';

    console.log(csv);
    
    // Extract values
    jsonData.forEach(obj => {
        const values = headers.map(header => obj[header]);
        csv += values.join(',') + '\n';
    });
    
    return csv;
}

function tableToCSV() {

   //let oldStringify = JSON.stringify;
   // JSON.stringify = (obj, replacer, space) => oldStringify(obj, replacer || ((key, value) => {if(key && value === obj) return "[recursive]"; return value;}), space);
 
   let titles__ = Object.entries(props.orders.data[0]);
    let titles = [];

    titles__.forEach((item) => {titles.push(item[0])});
    console.log(titles);

    let allData = [];

    allData[0]=titles;

    for(var i=0;i<props.orders.data.length;i++){
        let data__ = Object.entries(props.orders.data[i]);
        let data = [];
        let cnt = 0;
        data__.forEach((item) => {
            data.push(item[1]);
            cnt++;
            /*if(cnt!=2){
                data+=',';
            }*/
        });
        //console.log(data);
        //data = data.replaceAll(' ', '..');
        allData[i+1]=data;
    }

    console.log(allData);

    const rows = allData;

    let csvContent = "data:text/csv;charset=utf-8," 
        + rows.map(e => e.join(",")).join("\n");

    var encodedUri = encodeURI(csvContent);
    window.open(encodedUri);

    
    //console.log(allData);
  
    // Call this function to download csv file  
    //downloadCSVFile(allData);
}

function downloadCSVFile(csv_data) {

    // Create CSV file object and feed
    // our csv_data into it
    let CSVFile = new Blob([csv_data], {
        type: "text/csv"
    });

    // Create to temporary link to initiate
    // download process
    let temp_link = document.createElement('a');

    // Download csv file
    temp_link.download = "GfG.csv";
    let url = window.URL.createObjectURL(CSVFile);
    temp_link.href = url;

    // This link should not be displayed
    temp_link.style.display = "none";
    document.body.appendChild(temp_link);

    // Automatically click the link to
    // trigger download
    temp_link.click();
    document.body.removeChild(temp_link);
}

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
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <div class="content-center">
                                        <div>
                                            Advisers:
                                            <label class="ml-7 inline" for="one">One</label>
                                            <input class="ml-1 inline" type="radio" name="advisersFilter" id="one"
                                                :value="1" v-model="advisersFilter" />
                                            <label class="ml-4 inline" for="all">All</label>
                                            <input class="ml-1 inline" type="radio" name="advisersFilter" id="all"
                                                :value="2" v-model="advisersFilter" />

                                            <input class="ml-7 ml-1 inline" type="text" name="search" v-model="search"
                                                placeholder="Customer name" />
                                            <button class="ml-4 bg-blue-300 text-white py-2 px-6"
                                                @click="searchPurchasesByCustomer">
                                                Search
                                            </button>

                                            <button class="ml-4 bg-blue-300 text-white py-2 px-6" 
                                            :onclick="tableToCSV">
                                                download CSV
                                            </button>
                                        </div>
                                    </div><br>

                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                    Order id
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    Customer name
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    Total Amount
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    Adviser name
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                    Purchase Date
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="order in props.orders
                                                .data" :key="order.id">
                                                <td class="text-blue-800 border-b-2 border-gray-200 px-4 py-3">
                                                    <Link
                                                        :href="`/purchases/create?cid=${order.customer_id}&cname=${order.customer_name}`">
                                                    {{ order.id }}</Link>
                                                </td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    {{ order.customer_name }}
                                                </td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    {{ order.total }}
                                                </td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    {{ order.adviser_name }}
                                                </td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
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
                                <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto"></div>
                            </div>
                            <Pagination class="mt-6" :links="props.orders.links"></Pagination>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

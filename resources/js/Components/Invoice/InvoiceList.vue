<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h3>Invoice List</h3>
                        </div>
                        <hr />
                        <div>
                            <input placeholder="Search..." class="form-control mb-2 w-auto form-control-sm"
                                type="text" v-model="searchValue"/>
                            <EasyDataTable
                                buttons-pagination
                                alternating :headers="Header" :items="Item"
                                :rows-per-page="10"
                                :search-field="searchField"
                                :search-value="searchValue">

                                <template #item-action="{ id }">
                                    <button @click="showDetails(id)" class="viewBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0">
                                        <i class="fa text-sm fa-eye"></i>
                                    </button>
                                    <button @click="DeleteClick(id)" style="margin-left: 5px;" class="btn btn-danger btn-sm">Delete</button>
                                </template>

                            </EasyDataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal component for invoice details -->
        <InvoiceDetails v-if="show" :customer="customer" @close="closeModal"/>

    </div>
</template>
<script setup>
import { usePage, router } from '@inertiajs/vue3'
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster();
import InvoiceDetails from './InvoiceDetails.vue'
import { ref } from "vue";
let page = usePage()

const show = ref(false)
const customer = ref()

const searchValue = ref()
const searchField = ref(['customer.name'])

const Header = [
    { text: "Name", value: "customer.name" },
    { text: "Customer Id", value: "customer.id" },
    { text: "Phone", value: "customer.mobile" },
    { text: "Total", value: "total" },
    { text: "Discount", value: "discount" },
    { text: "Vat", value: "vat" },
    { text: "Payable", value: "payable" },
    { text: "Action", value: "action" },
];

const Item = ref(page.props.list)

const showDetails = (id) =>{
    show.value = !show.value
    customer.value = Item.value.find(item => item.id === id)
    console.log(customer.value);
}

const closeModal = () => {
    show.value = false
}

const DeleteClick = (id) => {
    let text = "Do you want to delete";
    if (confirm(text) === true) {
        router.get(`/invoice-delete/${id}`)
        toaster.success('Invoice Deleted Successfully');
    } else {
        text = "You canceled!";
    }
}

</script>

<template>
     <div class="container-fluid">
        <div class="row">
            <!-- Billing Selection -->
            <div class="col-md-4 col-lg-4 p-2">
                <div class="card">
                    <div class="card-body">
                        <h4>Billed To</h4>
                        <div class="shadow-sm h-100 bg-white rounded-3 p-3 mt-4">
                            <div class="row">
                                <div class="col-8">
                                    <span class="text-bold text-dark">BILLED TO</span>
                                    <p class="text-xs mx-0 my-1">Name: <span>{{ selectedCustomer?.name }}</span></p>
                                    <p class="text-xs mx-0 my-1">Email: <span>{{ selectedCustomer?.email }}</span></p>
                                    <p class="text-xs mx-0 my-1">User ID: <span>{{ selectedCustomer?.id }}</span></p>
                                </div>
                                <div class="col-4">
                                    <p class="text-bold mx-0 my-1 text-dark">Invoice</p>
                                    <p class="text-xs mx-0 my-1">Date: {{ new Date().toISOString().slice(0,10) }}</p>
                                </div>
                            </div>
                            <hr class="mx-0 my-2 p-0 bg-secondary"/>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table w-100">
                                        <thead>
                                            <tr class="text-xs">
                                                <th>Name</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="selectedProduct.length > 0"
                                                v-for="(product, index) in selectedProduct" :key="index"
                                                class="text-center">
                                                <td> {{ product.name }} </td>
                                                <td> {{ product.unit }}</td>
                                                <td> {{ product.price }}</td>
                                                <td>
                                                    <button @click="removeQty(product.id)" class="">-</button>
                                                    <button @click="addQty(product.id)" class="">+</button>
                                                    <button @click="removeProductFromSale(index)" class="btn btn-danger btn-sm">Remove</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr class="mx-0 my-2 p-0 bg-secondary"/>
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-bold text-xs my-1 text-dark">Total: <i class="bi bi-currency-dollar"></i> {{ calculateTotal() }}</p>
                                    <p class="text-bold text-xs my-1 text-dark">VAT (5%): <i class="bi bi-currency-dollar"></i> {{ vatAmount }}</p>
                                    <p>
                                        <button @click="applyVat" class="btn btn-info btn-sm my-1 bg-gradient-primary w-40">Apply VAT</button>
                                    </p>

                                    <p><button @click="removeVat" class="btn btn-secondary btn-sm my-1 bg-gradient-primary w-40">Remove VAT</button></p>

                                    <p><span class="text-xxs">Discount Mode:</span></p>
                                    <select v-model="usePercentageDiscount">
                                        <option :value="false">Flat Discount</option>
                                        <option :value="true">Percentage Discount</option>
                                    </select>

                                    <p class="text-bold text-xs my-1 text-dark">Discount: <i class="bi bi-currency-dollar"></i> {{ discountAmount }} </p>

                                    <div v-if="!usePercentageDiscount">
                                        <span class="text-xxs">Flat Discount:</span>
                                        <input v-model="flatDiscount" type="number" class="form-control w-40" min="0" />
                                        <p>
                                            <button @click="applyDiscount" class="btn btn-warning btn-sm my-1 bg-gradient-primary w-40">Apply Flat Discount</button>
                                        </p>
                                    </div>

                                    <div v-else>
                                        <span class="text-xxs">Discount (%):</span>
                                        <input v-model="discountPercent" type="number" class="form-control w-40" min="0" max="100" step="0.25" />
                                        <p><button @click="applyDiscount" class="btn btn-warning btn-sm my-1 bg-gradient-primary w-40" >Apply Percentage Discount</button></p>
                                    </div>

                                    <p><button @click="removeDiscount" class="btn btn-secondary btn-sm my-1 bg-gradient-primary w-40">Remove Discount</button></p>

                                    <hr class="mx-0 my-2 p-0 bg-secondary"/>
                                    <p class="text-bold text-xs my-1 text-dark">Payable: <i class="bi bi-currency-dollar"></i> {{ payable }}</p>
                                    <p><button @click="createInvoice" class="btn btn-success btn-sm my-3 bg-gradient-primary w-40">Confirm</button></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Selection -->
            <div class="col-md-4 col-lg-4 p-2">
                <div class="card">
                    <div class="card-body">
                        <h4>Select Product</h4>
                        <input
                            placeholder="Search..."
                            class="form-control mb-2 w-auto form-control-sm"
                            type="text"
                            v-model="searchProductValue"
                        />
                        <EasyDataTable
                            buttons-paginations
                            alternating
                            :items="ProductItem"
                            :headers="ProductHeader"
                            :rows-per-page="10"
                            :search-value="searchProductValue"
                            :seach-field="searchProductField"
                        >
                            <template #item-image="{image}">
                                <img :src="image" alt="Product Image" height="auto" width="40px"/>
                            </template>

                            <template #item-action="{id, image,name, price, unit}">
                                <button :class="['btn btn-sm', unit > 0 ? 'btn-success' : 'btn-danger']"
                                    :disabled="unit <= 0"
                                    @click="addProductToSale(id, image, name, price, unit)"
                                    >
                                    {{ unit > 0 ? 'Add' : 'Stock Out' }}
                                </button>
                            </template>
                        </EasyDataTable>
                        <!-- <p>{{ selectedProduct }}</p> -->
                    </div>
                </div>
            </div>

            <!-- Customer Selection -->
            <div class="col-md-4 col-lg-4 p-2">
                <div class="card">
                    <div class="card-body">
                        <h4>Select Customer</h4>
                        <input
                            placeholder="Search..."
                            class="form-control mb-2 w-auto form-control-sm"
                            type="text" v-model="searchCustomerValue"
                        />
                        <EasyDataTable
                            buttons-pagination
                            alternating
                            :headers="CustomerHeader"
                            :items="CustomerItem"
                            :rows-per-page="10"
                            :search-field="searchCustomerField"
                            :search-value="searchCustomerValue"
                            show-index
                        >
                            <template #item-number="{ id, name, email }">
                                <button @click="addCustomerToSale({ id, name, email })" class="btn btn-success btn-sm">Add</button>
                            </template>
                        </EasyDataTable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm,usePage, router } from '@inertiajs/vue3'
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster();
import { ref } from "vue";

let page = usePage()

const selectedProduct = ref([]);
const selectedCustomer = ref(null);

//customer
const CustomerHeader = [
    { text: "Name", value: "name" },
    { text: "Pick", value: "number" },
];

const CustomerItem = ref(page.props.customers);
const addCustomerToSale = (Customer)=>{
    selectedCustomer.value = (Customer);
}
const searchCustomerField = ref('name');
const searchCustomerValue = ref();
//end customer

//product
const ProductHeader = [
    { text: "Image", value: "image" },
    { text: "Name", value: "name" },
    { text: "QTY", value: "unit" },
    { text: "Action", value: "action" },
];

const ProductItem = ref(page.props.products);

const searchProductField = ref('name');
const searchProductValue = ref();

const addProductToSale = (id, image, name, price, productUnit)=>{
    const existingProduct = selectedProduct.value.find(product => product.id === id);
    if(existingProduct){
        if(existingProduct.existingQty > 0){
            existingProduct.unit++;
            existingProduct.existingQty--;
        }else{
            toaster.warning(`Product ${name} is out of stock`);
        }
    }else{
        if(productUnit > 0){
            const product = {
                id: id,
                image: image,
                name: name,
                price: price,
                unit: 1,
                existingQty: productUnit-1
            };
            selectedProduct.value.push(product);
            calculateTotal();
        }else{
            toaster.warning(`Product ${name} is out of stock`);
        }
    }
};//end method

//end product

//Start Billed to
const addQty = (id)=>{
    const product = selectedProduct.value.find(product => product.id === id);
    if(product.existingQty > 0){
        product.unit++;
        product.existingQty--;
        calculateTotal();
    }else{
        toaster.warning(`Product ${product.name} is out of stock`);
    }
};//end addQty

const removeQty = (id)=>{
    const product = selectedProduct.value.find(product => product.id === id);
    if(product.unit > 1){
        product.existingQty++;
        product.unit--;
        calculateTotal();
    }
};//end addQty

const removeProductFromSale = (index)=>{
    selectedProduct.value.splice(index,1);
    calculateTotal();
};//end method

const vatRate = ref(5);
const flatDiscount = ref(0);
const discountPercent = ref(0);
const total = ref(0);
const vatAmount = ref(0);
const discountAmount = ref(0);
const usePercentageDiscount = ref(false);

const calculateTotal = () =>{
    return selectedProduct.value.reduce((sum, product) => sum + product.price * product.unit, 0);
};

const applyVat = ()=>{
    vatAmount.value = (calculateTotal() * vatRate.value) / 100;
    calculateTotal();
}//end method

const removeVat = ()=>{
    vatAmount.value = 0;
    calculateTotal();
}//end method

const applyDiscount = () =>{
    if(usePercentageDiscount.value){
        discountAmount.value = (calculateTotal() * discountPercent.value) / 100;
    }else{
        discountAmount.value = flatDiscount.value;
    }
    calculatePayable();
}//end method

const removeDiscount = ()=>{
    discountAmount.value = 0;
    flatDiscount.value = 0;
    discountPercent.value = 0;
    calculatePayable();
}//end method

const calculatePayable = () =>{
    const totalAmount = calculateTotal();
    payable.value = totalAmount + vatAmount.value - discountAmount.value;
}//end method

const payable = ref(0);

const form = useForm({
    customer_id: '',
    products: '',
    vat: '',
    discount: '',
    payable: calculateTotal(),
    total: '',
});

const createInvoice = ()=>{
    if(!selectedCustomer.value){
        toaster.warning('Please select a customer');
        return;
    }
    if(selectedProduct.value.length === 0){
        toaster.warning('Please select at least one product');
        return;
    }

    form.customer_id = selectedCustomer.value.id;
    form.products = selectedProduct.value;
    form.total = total.value
    form.vat = vatAmount.value;
    form.discount = discountAmount.value;
    form.payable = payable.value;

    const calculatedTotal = calculateTotal();
    form.total = calculatedTotal;
    form.payable = payable.value;

    form.post('/invoice-create',{
        onSuccess: ()=>{
            if(page.props.flash.status === true){
                toaster.success(page.props.flash.message);
                setTimeout(()=>{
                    router.get('/InvoiceListPage');
                },500);
            }else{
                toaster.warning(page.props.flash.message);
            }
        }
    })
};

//end Billed to

</script>

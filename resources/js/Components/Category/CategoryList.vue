<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12"></div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h3>Category</h3>
                        </div>
                        <hr />
                        <div class="float-end">
                            <Link href="/CategorySavePage?id=0" class="btn btn-success mx-3 btn-sm">
                                Add Category
                            </Link>
                        </div>

                        <!-- Modal -->

                        <div>
                            <input placeholder="Search..." class="form-control mb-2 w-auto form-control-sm" type="text"
                                v-model="searchValue">
                            <EasyDataTable
                                buttons-pagination
                                alternating
                                :headers="Header"
                                :items="Item"
                                :rows-per-page="10"
                                :search-field="searchField"
                                :search-value="searchValue"
                                show-index
                                >
                                <template #item-number="{ id, name }">
                                    <a class="btn btn-success mx-3 btn-sm" :href="`/CategorySavePage?id=${id}`">Edit</a>
                                    <button class="btn btn-danger btn-sm" @click="DeleteClick(id)">Delete</button>
                                </template>
                            </EasyDataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { Link, useForm, usePage, router } from "@inertiajs/vue3";
    import { createToaster } from "@meforma/vue-toaster";
    const toaster = createToaster({ position: "top-right" });
    import { ref } from "vue";


    let page = usePage();
    const Header = [
        { text: "Name", value: "name" },
        { text: "Action", value: "number" },
    ]
    const Item = ref(page.props.categories);

    const searchValue = ref();
    const DeleteClick = (id) => {
        let text = "Do you went to delete"
        if(confirm(text)===true){
            router.get(`/delete-category/${id}`);
            toaster.success("Category Deleted successfully");
        }else{
            text = "you canceled!";
        }
    }
</script>

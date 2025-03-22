<template>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end">
                            <Link href="/CategoryPage" class="btn btn-success mx-3 btn-sm">
                            Back
                            </Link>
                        </div>
                        <form @submit.prevent="submit">
                            <div class="card-body">
                                <h4>Save Category</h4>
                                <input id="name" v-model="form.name" name="name" placeholder="Category Name"
                                    class="form-control" type="text" />
                                <br />
                                <button type="submit" class="btn w-100 btn-success">Save Change</button>
                            </div>
                        </form>
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

const urlParams = new URLSearchParams(window.location.search);
let id = ref(parseInt(urlParams.get("id")));

const form = useForm({ name: "", id: id });
const page = usePage();

let URL = "/create-category";
let category = page.props.category;

if (id.value !== 0 && category !== null) {
    URL = "/update-category";
    form.name = category.name;
}

function submit() {
    if (form.name.length === 0) {
        toaster.warning("Name is required");
    } else {
        form.post(URL, {
            onSuccess: () => {
                if (page.props.flash.status === true) {
                    router.get('/CategoryPage');
                    toaster.success(page.props.flash.message);
                } else {
                    toaster.error(page.props.flash.message);
                }
            }
        });
    }
}

</script>

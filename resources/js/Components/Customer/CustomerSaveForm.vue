<template>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end">
                            <a href="/CustomerPage" class="btn btn-success mx-3 btn-sm">
                                Back
                            </a>
                        </div>
                        <form @submit.prevent="submit">
                            <div class="card-body">
                                <h4>Save Customer</h4>
                                <input id="name" name="name" v-model="form.name" placeholder="Customer Name"
                                    class="form-control" type="text" />
                                <br />
                                <input id="email" name="email" v-model="form.email" placeholder="Customer Email"
                                    class="form-control" type="email" />
                                <br />
                                <input id="mobile" name="phone" v-model="form.mobile" placeholder="Customer Phone"
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
import { useForm, usePage, router, Link } from '@inertiajs/vue3'
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster();
import { ref } from "vue";

const urlParams = new URLSearchParams(window.location.search)
let id = ref(parseInt(urlParams.get('id')))

const form = useForm({ name: '', email: '', mobile: '', id: id })
const page = usePage()

let URL = "/create-customer";
let list = page.props.customer

if (id.value !== 0 && list !== null) {
    URL = "/update-customer";
    form.name = list['name']
    form.id = list['id']
    form.email = list['email']
    form.mobile = list['mobile']
}

function submit() {
    form.post(URL, {
        onSuccess: () => {
            if (page.props.flash.status === true) {
                toaster.success(page.props.flash.message);
                setTimeout(() => {
                    router.get("/CustomerPage")
                }, 500)
            } else {
                toaster.warning(page.props.flash.message)
            }
        }
    })
}
</script>

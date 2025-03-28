<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card animated fadeIn w-100 p-3">
                    <form @submit.prevent="submit">
                        <div class="card-body">
                            <h4>Profile Update</h4>
                            <hr />
                            <div class="container-fluid m-0 p-0">
                                <div class="row m-0 p-0">
                                    <div class="col-md-4 p-2">
                                        <label>Name</label>
                                        <input id="name" v-model="form.name" placeholder="First Name" class="form-control" type="text" />
                                    </div>

                                    <div class="col-md-4 p-2">
                                        <label>Email Address</label>
                                        <input id="email" disabled v-model="form.email" placeholder="User Email" class="form-control" type="email" />
                                    </div>

                                    <div class="col-md-4 p-2">
                                        <label>Mobile Number</label>
                                        <input id="mobile" v-model="form.mobile" placeholder="Mobile" class="form-control" type="mobile" />
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-md-4 p-2">
                                        <button type="submit" class="btn mt-3 w-100  btn-success">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useForm, usePage, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster();

const form = useForm({ name: "", email: "", mobile: "" });
const page = usePage();

form.name = page.props.user.name;
form.email = page.props.user.email;
form.mobile = page.props.user.mobile;

function submit() {
    if (form.name.length === 0) {
        toaster.error("Name is required");
    } else if (form.email.length === 0) {
        toaster.error("Email is required");
    } else if (form.mobile.length === 0) {
        toaster.error("Mobile is required");
    } else {
        form.post("/user-update", {
            onSuccess: () => {
                if (page.props.flash.status === true) {
                    router.get('/ProfilePage');
                    toaster.success(page.props.flash.message);
                } else {
                    toaster.error(page.props.flash.message);
                }
            }
        });
    }
}
</script>

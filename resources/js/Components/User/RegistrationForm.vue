<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-10 center-screen">
                <div class="card animated fadeIn w-100 p-3">
                    <form @submit.prevent="submit">
                        <div class="card-body">
                            <h4>Sign Up</h4>
                            <hr />
                            <div class="container-fluid m-0 p-0">
                                <div class="row m-0 p-0">

                                    <div class="col-md-4 p-2">
                                        <label>Name</label>
                                        <input id="name" v-model="form.name" placeholder="First Name" class="form-control" type="text" />
                                    </div>

                                    <div class="col-md-4 p-2">
                                        <label>Email Address</label>
                                        <input id="email" v-model="form.email" placeholder="User Email" class="form-control" type="email" />
                                    </div>

                                    <div class="col-md-4 p-2">
                                        <label>Mobile Number</label>
                                        <input id="mobile" v-model="form.mobile" placeholder="Mobile" class="form-control" type="mobile" />
                                    </div>
                                    <div class="col-md-4 p-2">
                                        <label>Password</label>
                                        <input id="password" v-model="form.password" placeholder="User Password" class="form-control"
                                            type="password" />
                                    </div>
                                    <div class="col-md-4 p-2">
                                        <label>Confirm Password</label>
                                        <input id="cpassword" placeholder="User Confirm Password" class="form-control"
                                            type="password" />
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-md-4 p-2">
                                        <button type="submit" href="loginForm.html"
                                            class="btn mt-3 w-100  btn-success">Complete</button>
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
import { Link, useForm, usePage, router } from "@inertiajs/vue3";
    import { createToaster } from "@meforma/vue-toaster";
    const toaster = createToaster();

    const form = useForm({ name: "", email: "", mobile: "", password: "" });
    const page = usePage();

    function submit(){
        if(form.name.length === 0){
            toaster.warning("Name is required");
        }else if(form.email.length === 0){
            toaster.warning("Email is required");
        }else if(form.mobile.length === 0){
            toaster.warning("Mobile is required");
        }else if(form.password.length === 0){
            toaster.warning("Password is required");
        }else{
            form.post("/user-registration", {
                onSuccess: () => {
                    if(page.props.flash.status === true){
                        router.get('/DashboardPage');
                        toaster.success("Login successful");
                    }else{
                        toaster.error(page.props.flash.message);
                    }
                }
            });
        }
    }
</script>

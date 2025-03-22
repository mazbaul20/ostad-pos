<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-90 p-4">
                    <form @submit.prevent="submit">
                        <div class="card-body">
                            <h4>SET NEW PASSWORD</h4>
                            <br/>
                            <label>New Password</label>
                            <input id="password" v-model="form.password"  placeholder="New Password" class="form-control" type="password"/>
                            <br/>
                            <label>Confirm Password</label>
                            <input id="cpassword" v-model="form.cpassword"  placeholder="Confirm Password" class="form-control" type="password"/>
                            <br/>
                            <button type="submit" class="btn w-100 btn-success">Next</button>
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
const toaster = createToaster({ position: "top-right" });

const form = useForm({ password: "", cpassword: ""});
const page = usePage();

function submit(){
    if(form.password.length === 0){
        toaster.warning("Password is required");
    }else if(form.cpassword.length === 0){
        toaster.warning("Confirm Password is required");
    }else if(form.password !== form.cpassword){
        toaster.warning("Password and Confirm Password does not match");
    }else{
        form.post("/reset-password", {
            onSuccess: () => {
                if(page.props.flash.status === true){
                    router.get('/login');
                    toaster.success(page.props.flash.message);
                }else{
                    toaster.error(page.props.flash.message);
                }
            }
        });
    }
}
</script>

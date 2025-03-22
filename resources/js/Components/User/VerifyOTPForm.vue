<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-90  p-4">
                    <form @submit.prevent="submit">
                        <div class="card-body">
                            <h4>ENTER OTP CODE</h4>
                            <br/>
                            <label>4 Digit Code Here</label>
                            <input id="otp" v-model="form.otp" placeholder="Code" class="form-control" type="text"/>
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

const form = useForm({ otp: ""});
const page = usePage();

    function submit(){
        if(form.otp.length === 0){
            toaster.warning("OTP is required");
        }else{
            form.post("/verify-otp", {
                onSuccess: () => {
                    if(page.props.flash.status === true){
                        router.get('/reset-password');
                        toaster.success(page.props.flash.message);
                    }else{
                        toaster.error(page.props.flash.message);
                    }
                }
            });
        }
    }

</script>

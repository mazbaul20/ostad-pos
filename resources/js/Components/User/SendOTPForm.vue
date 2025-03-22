<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-90  p-4">
                    <form @submit.prevent="submit">
                        <div class="card-body">
                            <h4>EMAIL ADDRESS</h4>
                            <br/>
                            <label>Your email address</label>
                            <input id="email" v-model="form.email" placeholder="User Email" class="form-control" type="email"/>
                            <br/>

                            <button type="submit" class="btn mt-3 w-100  btn-success">Next</button>
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

    const form = useForm({ email: "", password: "" });
    const page = usePage();

    function submit(){
        if(form.email.length === 0){
            toaster.warning("Email is required");
        }else{
            form.post("/send-otp", {
                onSuccess: () => {
                    if(page.props.flash.status === true){
                        router.get('/verify-otp');
                        toaster.success(page.props.flash.message);
                    }else{
                        toaster.error(page.props.flash.message);
                    }
                }
            });
        }
    }
</script>

<template>
    <div>
        <nav id="topNav" class="navbar fixed-top bg-success top-navbar">
            <div class="container-fluid">
                <a id="MenuBar" @click="NavOpenClose" class="icon-nav mx-0 my-1 h5">
                    <i class="fa text-white fa-bars"></i>
                </a>
            </div>
        </nav>
        <div id="sideNav" class="side-nav-open">
            <div class="side-nav-top text-center">
                <img alt="" class="side-nav-logo" src="../Assets/img/logo.svg" />
            </div>

            <Link href="/DashboardPage" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-tachometer-alt text-green" /></span>
                <span class="side-bar-item-caption">Dashboard</span>
            </Link>

            <Link href="/CategoryPage" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-th-list text-green" /></span>
                <span class="side-bar-item-caption">Category</span>
            </Link>

            <Link href="/CustomerPage" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-users text-green" /></span>
                <span class="side-bar-item-caption">Customer</span>
            </Link>

            <Link href="/ProductPage" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-box text-green" /></span>
                <span class="side-bar-item-caption">Product</span>
            </Link>

            <Link href="/create-sale" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-shopping-cart text-green" /></span>
                <span class="side-bar-item-caption">Create Sale</span>
            </Link>

            <Link href="/InvoiceListPage" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-file-invoice-dollar text-green" /></span>
                <span class="side-bar-item-caption">Invoice</span>
            </Link>

            <Link href="/ProfilePage" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-user-circle text-green" /></span>
                <span class="side-bar-item-caption">Profile</span>
            </Link>

            <Link href="/user-logout" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-sign-out-alt text-green" /></span>
                <span class="side-bar-item-caption">Logout</span>
            </Link>

        </div>
        <div id="content" class="content">
            <div class="container-fluid">
                <main>
                    <slot></slot>
                </main>
            </div>
        </div>
    </div>

</template>
<script setup>
import { Link } from '@inertiajs/vue3'
</script>

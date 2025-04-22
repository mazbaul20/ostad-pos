#### 1. Laravel(update version) Project Creation
```cmd
laravel new my-app
```
# [Inertia](https://inertiajs.com/) - Server Side Install 
---
(a) Inertia composer installation
```cmd
composer require inertiajs/inertia-laravel
```

(b) Configure Blade Template Engine - Prepare Master Blade Layout
	`/views/app.blade.php`

```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/js/app.js')
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>
```

(c) Create Inertia Middleware
```cmd
php artisan inertia:middleware
```

(d) Add Inertia Middleware With Your Route Middleware
`bootstrap/app.php`

```php
use App\Http\Middleware\HandleInertiaRequests;

$middleware->web(append: [
  HandleInertiaRequests::class,
]);
```
# [Inertia](https://inertiajs.com/) - Client Side Install
---
##### (a) Install Vue JS
```cmd
npm install @inertiajs/vue3
```

Import `resources/js/app.js`
```js
import { router } from '@inertiajs/vue3'
```

##### (b) configure vite
```cmd
npm i @vitejs/plugin-vue
```

Import `vite.config.js`
```js
import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
// import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue(),
        // tailwindcss(),
    ],
    build: {
        manifest: true,
        outDir: "public/build",
    },
});
```

update
```js
plugins: [
	vue(),
],
build: {
	manifest: true,
	outDir: "public/build",
},
```
##### (c) configure app.js
```cmd
npm i vue
```
###### Import `resources/js/app.js`
```js
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
createInertiaApp({
	resolve: name => {
	  const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
	  return pages[`./Pages/${name}.vue`]
	},
	setup({ el, App, props, plugin }) {
	  createApp({ render: () => h(App, props) })
		.use(plugin)
		.mount(el)
	},
})
```
---
#### 4. Vue js frontend structure inside  `resources/js/`
---
- Components (Naming Convention Optional)
- Utility (Naming Convention Optional)
- Pages (Naming Convention Mandatory)
#### 5. Lets create our first website
---
- Home Page `[AppNavbar+Hero+Footer]`
- Profile page `[AppNavbar+ProfileForm+Footer]`
- Lets create a controller SiteController
- Lets create function for Render Vue.js Pages
- Lets define route in web.php
#### 6. Let's Run Our `Laravel+Vue` Project
---
   - php artisan serve
   - npm run dev
   - Access From Running Via Vite
   - Access From Running Via Artisan
#### 7. How Rendering Works Here
---
   - `"/" Route-->Middleware-->Controller-->Render--->HomePage.vue`
   - `"/profile" Route-->Middleware-->Controller-->Render--->ProfilePage.vue`
#### 8. Set Our First SPA Navigation
   - Use Inertia Build In Link component
```js
<script setup>
	import { Link } from '@inertiajs/vue3';
</script>

<template>
    <h1 class="text-danger">This is Test page</h1>
    <Link href="/">Home</Link>
</template>
```
#### 9. How to set Routing Progress Like vue JS
```cmd
npm i nprogress
```
- Add CSS CDN 
- `resources/view/app.blade.php`
```css
<link rel="stylesheet" href="{{url('https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css')}}" />
```
- Add Route Start End of `@app.js`
###### Added `resources/js/app.js`

```js
import NProgress from 'nprogress'

router.on('start', () => {
    NProgress.start()
})

router.on('finish', () =>{
    NProgress.done()
})
```
---
### Vue.js Packages Installation Guide
---
##### 1. Toast Notifications: [`@meforma/vue-toaster`](https://github.com/MeForma/vue-toaster)

```cmd
npm i @meforma/vue-toaster
```

**Use Case**

```php
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({
    position: "top-right",
});
```

A lightweight toast notification library for Vue 3.
##### 2. Rich Text Editor: [`@vueup/vue-quill`](https://github.com/vueup/vue-quill)

```cmd
npm i @vueup/vue-quill
```

Vue 3 wrapper for the Quill rich-text editor to add WYSIWYG functionality.
##### 3. Data Table: [`vue3-easy-data-table`](https://hc200ok.github.io/vue3-easy-data-table-doc/)

```cmd
npm i vue3-easy-data-table
```
###### Import `resources/js/app.js`
```js
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';

setup({ el, App, props, plugin }) {
	const app = createApp({ render: () => h(App, props) })
	app.use(plugin)
	app.component('EasyDataTable', Vue3EasyDataTable)
	app.mount(el)
},
```

Simple and easy-to-use data table component for Vue 3 applications.
##### 4. Chart Libraries: [`chart.js`](https://www.chartjs.org/), [`vue-chartjs`](https://vue-chartjs.org/), [`apexcharts`](https://apexcharts.com/)

```cmd
npm i chart.js
```

```cmd
npm i chart.js
```

```cmd
npm i apexcharts
```

- **chart.js**: JavaScript library for creating interactive charts.
- **vue-chartjs**: Vue wrapper for Chart.js.
- **apexcharts**: Modern charting library for data visualization.

##### 5. Skeleton Screens: [`vue-content-loader`](https://github.com/egoist/vue-content-loader)

```cmd
npm i vue-content-loader
```

Easily create skeleton screens for Vue 3 applications.
##### 6. Circular Progress Bar: [`vue3-circle-progress`](https://www.npmjs.com/package/vue3-circle-progress)

```cmd
npm i vue3-circle-progress
```

A customizable circular progress bar component for Vue 3.
##### 7. Lottie Animations: [`vue3-lottie`](https://www.npmjs.com/package/vue3-lottie)

```cmd
npm i vue3-lottie
```

A Vue 3 component for rendering Lottie animations.
##### 8. CSS Framework: [`bootstrap`](https://getbootstrap.com/)

```cmd
npm i bootstrap
```

Popular CSS framework for building responsive and mobile-first websites.

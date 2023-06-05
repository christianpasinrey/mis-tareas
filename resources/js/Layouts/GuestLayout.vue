<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <Link :href="'/mis-tareas/public'" class="absolute z-20 top-40">
            <h1 class="cursor-pointer rounded-md animate-bounce bg-transparent border border-white text-white font-medium px-6 py-4 text-4xl">MIS TAREAS</h1>
        </Link>
        <slot />

    </div>
</template>

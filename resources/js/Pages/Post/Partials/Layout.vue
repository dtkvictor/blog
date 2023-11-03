<template>
    <DefaultLayout :routeSearch="route('site.filter') + '/title'" placeholder="Install Lampp...">
        <slot></slot>
    </DefaultLayout>
</template>
<script setup>
    import DefaultLayout from '@/Layouts/DefaultLayout.vue';
</script>
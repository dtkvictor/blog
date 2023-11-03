<template>    
    <Head :title="title"/>        
    <section class="flex flex-wrap justify-center">
        <div class="w-full md:w-3/5">
            <SubHeader class='mb-5' :title="title"></SubHeader>
            <slot></slot>                
        </div>                                  
        <Pagination :links="paginationLinks"/>  
    </section>    
</template>

<script setup>    
    import { Head } from '@inertiajs/vue3';
    import SubHeader from '@/Components/SubHeader.vue';
    import Pagination from '@/Components/Pagination.vue';    

    const props = defineProps({
        title: {
            type: String,
            required: true,            
        },
        paginationLinks: {
            type: Array,
            default: [],
        }            
    })
</script>
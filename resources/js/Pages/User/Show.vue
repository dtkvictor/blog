<template>
    <DefaultLayout>        
        <section class="flex flex-wrap justify-center">         
            <div class="flex flex-wrap justify-center w-3/5">                                                   
                <img class="rounded w-[150px] h-[150px] shadow" :src="user.picture">                
                <p>{{ user.name }}</p>
                <Pagination :links="posts.links"/>                                    
            </div>
        </section>            
    </DefaultLayout>    
</template>
<script>
    import DefaultLayout from '@/Layouts/DefaultLayout.vue';    
    import FilterBar from '@/Components/FilterBar.vue';    
    import Pagination from '@/Components/Pagination.vue';
    import { Link } from '@inertiajs/vue3';

    export default {        
        components: { 
            DefaultLayout,            
            FilterBar,    
            Pagination,                     
            Link
        },
        props: ['user', 'posts']
    }
</script>
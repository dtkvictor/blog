<template>
    <DefaultLayout placeholder="My Post..." :routeSearch="route('post.filter') + '/title'">
        <Container title="Minhas Postagens" :paginationLinks="response.links">            
            <div class="relative flex justify-between gap-3 w-full mb-5">                                                                                     
                <CreatePost btnClass="rounded-full"/>
                <FilterBar 
                    class="absolute right-0" 
                    :orderByFilters="orderByFilters" 
                    :hidden="['author']"
                    :filteringRoute="route('post.filter')"
                />
            </div>
            <div class="flex items-center justify-between gap-3 rounded p-3 bg-white shadow mb-5" v-for="post in response.data" key="post.id">
                <img :src="post.thumb" class="w-[100px] h-[100px] aspect-[1/1] rounded">
                <div class="overflow-hidden w-3/5">         
                    <Link :href="route('site.show', post.slug)" class="text-blue-500 underline"> {{ post.title }}</Link>                                                                                  
                    <p v-if="post.category">Categoria: {{ post.category.name }}</p>                                                                     
                    <p>Likes: {{ post.likes ?? 0 }}</p>                    
                </div>
                <div class="flex flex-col justify-center items-center gap-3 ">    
                    <EditPost btnClass="w-[50px] h-[50px] rounded" :post="post"/>
                    <DeletePost :post="post" btnClass="w-[50px] h-[50px] rounded"/>
                </div>
            </div>
            <NotFound contentClass="md:w-full" v-if="response.data < 1"/>
        </Container>
    </DefaultLayout>
</template>
<script>
    import DefaultLayout from '@/Layouts/DefaultLayout.vue';
    import Container from '@/Components/Container.vue';
    import FilterBar from '@/Components/FilterBar.vue';
    import DeletePost from './Partials/DeletePost.vue';
    import CreatePost from './Partials/CreatePost.vue';
    import EditPost from './Partials/EditPost.vue';
    import NotFound from '@/Components/NotFound.vue';
    import { Link } from '@inertiajs/vue3';

    export default {        
        components: {
            DefaultLayout, 
            Container,
            FilterBar,     
            Link,
            CreatePost, 
            EditPost,
            DeletePost,
            NotFound
        },
        props: ['response'],
        data: () => ({
            orderByFilters: [                
                { name: 'Alfabética', value: 'title' },
                { name: 'Relevância', value: 'relevance' },                
            ]
        }),
    }
</script>
<template>
    <Layout>
        <Head title="Home"/>        
        <section class="flex flex-wrap justify-center gap-5">            
            <div class="w-full md:w-3/5">
                <div class="relative flex justify-between gap-3 w-full mb-5 h-[48px]">                                                                                     
                    <CreatePost btnClass="rounded-full" v-if="auth && auth.admin"/>
                    <FilterBar 
                        class="absolute right-0" 
                        :orderByFilters="orderByFilters"
                        :filteringRoute="route('site.filter')"                         
                    />
                </div>                                                        
                <div v-for="post in posts" :key="post.id">
                    <div class="flex flex-col gap-3 p-3 mb-5 rounded shadow bg-white w-full h-fit">
                        <div class="flex flex-col">
                            <img class="w-full h-48 rounded block md:hidden overflow-hidden" :src="post.thumb" :alt="post.slug">                                        
                            <Link class="text-xl underline" :href="route('site.show', post.slug)">{{ post.title }}</Link>
                            <div href=""> 
                                <span>Categoria: </span>
                                <Link :href="route('site.filter', 'category/' + post.category.slug)">{{ post.category.name }}</Link>
                            </div>
                            <div>                                                
                                <span>Por: </span> 
                                <Link :href="route('site.filter', 'author/' + post.user.slug)"> {{ post.user.name }}</Link>
                            </div>
                            <p>Likes: {{ post.likes_count }}</p>                            
                            <p>Postado em: {{ formatDate(post.created_at) }}</p>    
                            <p>Atualizado em: {{ formatDate(post.updated_at) }}</p>    
                        </div>
                        <div class="flex gap-3">
                            <img class="w-48 h-48 rounded hidden md:block overflow-hidden" :src="post.thumb" :alt="post.slug">                                        
                            <p v-html="post.content"></p>                        
                        </div>                
                    </div>
                </div>            
                <Pagination :links="response.links"/>                                     
            </div>
        </section>                   
    </Layout>
</template>
<script>    
    import Layout from '@/Pages/Post/Partials/Layout.vue'
    import FilterBar from '@/Components/FilterBar.vue';
    import Pagination from '@/Components/Pagination.vue';
    import CreatePost from './Partials/CreatePost.vue';
    import { Head, Link } from '@inertiajs/vue3';

    export default {        
        components: { Layout, FilterBar, Head, Link, Pagination, CreatePost },
        props: ['response', 'others', 'success', 'error'],
        data: () => ({
            orderByFilters: [
                { name: 'Alfabética', value: 'title' },
                { name: 'Criação', value: 'created' },
                { name: 'Atualização', value: 'updated' },
                { name: 'Relevância', value: 'relevance' },
            ]
        }),
        computed: {
            posts(){
                return this.response.data;
            },
            auth() {
                return this.$page.props.auth;
            },
        },
        methods: {
            formatDate(date) {
                date = new Date(date);
                return date.toLocaleDateString();                
            }                     
        }                
    }
</script>
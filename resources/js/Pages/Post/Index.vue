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
                <div v-for="post in posts" :key="post.id" class="slide">
                    <div class="flex flex-col md:flex-row gap-3 p-3 mb-5 rounded shadow bg-white w-full h-fit">
                        <div class="w-full md:w-[25%] h-fit border">
                            <img 
                                class="w-full h-full aspect-[1/1] rounded overflow-hidden" 
                                :src="post.thumb" 
                                :alt="post.slug"
                                onerror="this.src='assets/image/catload.gif'"
                            >                                        
                        </div>                        
                        <div class="w-full md:w-[75%] flex flex-col">                            
                            <Link class="text-xl underline" :href="route('site.show', post.slug)">{{ post.title }}</Link>
                            <div href=""> 
                                <span>Categoria: </span>                                
                                <Link :href="route('site.filter', 'category/' + post?.category?.slug)">{{ post?.category?.name }}</Link>
                            </div>          
                            <div class="break-all leading-normal overflow-hidden ellipse" v-html="post.content"></div>
                        </div>                        
                    </div>
                </div>    
                <NotFound contentClass="md:w-full" v-if="response.data.length < 1"/>        
                <Pagination :links="response.links" v-show="showPagination"/>                                     
            </div>
        </section>                
    </Layout>
</template>
<script>    
    import Layout from '@/Pages/Post/Partials/Layout.vue'
    import FilterBar from '@/Components/FilterBar.vue';
    import Pagination from '@/Components/Pagination.vue';
    import CreatePost from './Partials/CreatePost.vue';
    import NotFound from '@/Components/NotFound.vue';
    import { Head, Link } from '@inertiajs/vue3';

    export default {        
        components: { Layout, FilterBar, Head, Link, Pagination, CreatePost, NotFound },
        props: ['response', 'others', 'success', 'error'],
        mounted() {        
            this.animateLoadPosts();
        },
        data: () => ({
            orderByFilters: [                
                { name: 'Alfabética', value: 'title' },
                { name: 'Relevância', value: 'relevance' },                
            ],
            posts: [],
        }),
        computed: {            
            auth() {
                return this.$page.props.auth;
            },
            showPagination() {
                return this.response.data.length == this.posts.length;
            },            
            getPosts() {
                return this.response.data;
            }
        },
        methods: {
            formatDate(date) {
                date = new Date(date);
                return date.toLocaleDateString();                
            },
            animateLoadPosts(){
                let delay = 0;    
                this.getPosts.forEach(post => {
                    setTimeout(() => {
                        this.posts.push(post)
                    }, delay);
                    delay += 500;
                });            
            }
        },
        watch: {
            getPosts() {
                this.posts = [];
                this.animateLoadPosts();
            }
        }                
    }
</script>
<template>
    <DefaultLayout>
        <Head title="Home"/>        
        <section class="flex flex-wrap justify-center gap-5" v-if="posts.length > 0">
            <div class="flex justify-end gap-3 w-full md:w-3/5 absolute px-5 md:px-3">     
                <FilterBar></FilterBar>          
                <div class="absolute left-5" v-if="auth && auth.admin">
                    <Link
                        :href="route('post.create')"
                        class="flex justify-center items-center rounded-full shadow p-3 hover:shadow-lg active:scale-75  bg-white">
                        <span class="material-icons text-lg" translate="no">edit</span>
                    </Link>
                </div>                           
            </div>
            <div  class="w-full md:w-3/5 mt-[4.3rem]">                        
                <div v-for="post in posts" :key="post.id">
                    <div class="flex flex-col gap-3 p-3 mb-5 rounded shadow bg-white w-full h-fit">
                        <div class="flex flex-col">
                            <img class="w-full h-48 rounded block md:hidden" :src="post.thumb" :alt="post.slug">                                        
                            <Link class="text-xl underline" :href="route('post.show', post.slug)">{{ post.title }}</Link>
                            <div href=""> 
                                <span>Categoria: </span>
                                <Link :href="route('post.filter', 'category/' + post.category.slug)">{{ post.category.name }}</Link>
                            </div>
                            <div>                                                
                                <span>Por: </span> 
                                <Link :href="route('post.filter', 'author/' + post.user.slug)"> {{ post.user.name }}</Link>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <img class="w-48 h-48 rounded hidden md:block" :src="post.thumb" :alt="post.slug">                                        
                            <p>{{ post.content }}</p>                        
                        </div>                
                    </div>
                </div>
            </div>                   
        </section>        
    </DefaultLayout>
</template>
<script>    
    import DefaultLayout from '@/Layouts/DefaultLayout.vue';    
    import FilterBar from '@/Pages/Post/Partials/FilterBar.vue'
    import { Head, Link } from '@inertiajs/vue3';    

    export default {
        components: { DefaultLayout, FilterBar, Head, Link },
        props: ['response', 'others'],
        computed: {
            posts(){
                return this.response.data;
            },
            auth() {
                return this.$page.props.auth;
            }
        }
    }
</script>
<template>
    <Layout>
        <Head :title="post.title"/>
        <div class="flex flex-col md:flex-row justify-center gap-5">            
            <div class="bg-white w-full md:w-[75%] h-fit shadow sm:shadow-0 rounded p-3 gap-5">
                <div class="w-full flex flex-wrap gap-3">
                    <div class="flex justify-center w-full md:w-[50%] h-fit">
                        <img 
                            :src="post.thumb" 
                            :alt="post.title" 
                            class="rounded border w-full sm:w-[70%] md:w-[90%] h-fit aspect-[1/1]"
                        >                     
                    </div>                                                    
                    <div class="flex-1">                        
                        <h1 class="w-full text-4xl">{{ post.title }}</h1>                                                                            
                        <div>                            
                            <span>Categoria:</span>
                            <Link class="ms-1 underline" :href="route('site.filter', 'category/' + post?.category?.slug)">
                                {{ post?.category?.name ?? 'Undefined' }}
                            </Link>                                                                                                                        
                        </div>
                        <div>
                            <span>Postado em: </span>
                            <span>{{ formatDate(post.created_at) }}</span>
                        </div>
                        <Link 
                            class="flex gap-1 items-center active:scale-110 h-fit" 
                            preserve-scroll
                            method="post" 
                            as="button"
                            :href="route('like')"                             
                            :data="{ 'post': post.id }"                             
                        >
                            <span :class="['material-icons',{ 'text-blue-500': post.like }]" translate="no">thumb_up</span>                            
                        </Link>                                                
                    </div>                                                                  
                    <div v-html="post.content" class="w-full break-all"></div>                                      
                </div>                                                

                <h3 class="text-xl my-1">Comentários: </h3>
                <Comments 
                    :postId="post.id"
                    :comments="comments"
                    :auth="auth"
                />
            </div>

            <div class="w-full md:w-[25%] flex flex-col gap-5">
                <div class="flex flex-wrap w-full bg-white shadow sm:shadow-0 rounded p-3 flex-col" 
                    v-for="post, key in related" :key="key"
                >   
                    <div class="w-[100px] md:w-full">
                        <img :src="post.thumb" :alt="post.title" class="w-full rounded border aspect-[1/1]">
                    </div>
                    <div class="flex flex-col">
                        <div>
                            <span> Categoria: </span>
                            <Link class="ms-1" :href="route('site.filter', 'category/' + post?.category?.slug)">
                                {{ post?.category?.name ?? 'Undefined' }}
                            </Link>                
                        </div>
                        <div>
                            <span> Por: </span>                                                    
                            <Link class="ms-1" :href="route('site.filter','author/' + post?.user?.name)">
                                {{ post?.user?.name ?? 'Undefined' }}
                            </Link>                
                        </div>

                        <Link :href="route('site.show', post.slug)" class="underline">
                            {{ post.title }}
                        </Link>                    
                    </div>                                                             
                </div>
            </div>
        </div>
    </Layout>            
</template>
<script>    
    import Layout from '@/Pages/Post/Partials/Layout.vue';
    import Comments from '@/Pages/Post/Partials/Comments.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';    
    import DeletePost from '@/Pages/Post/Partials/DeletePost.vue';
    import { Head, Link } from '@inertiajs/vue3';        

    export default {
        components: { Layout, PrimaryButton, DeletePost, Comments, Head, Link},
        props: ['post', 'related', 'comments'],        
        computed: {            
            likeRoute() {                
                return route('like');
            },            
            auth() {
                return this.$page.props.auth;
            },
            isTheOwner() {                
                if(!this.auth.admin) return false;
                if(this.auth.id != this.post.user) return false;
                return true;
            }            
        },
        methods: {
            formatDate(date) {
                date = new Date(date);
                return date.toLocaleDateString();                
            }                     
        }                        
    }
</script>
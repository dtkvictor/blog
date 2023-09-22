<template>
    <DefaultLayout>
        <Head :title="post.title"/>
        <div class="flex flex-col md:flex-row justify-center gap-5">            
            <div class="bg-white w-full md:w-[75%] h-fit shadow sm:shadow-0 rounded p-3 gap-5">
                <div class="w-full flex flex-col md:flex-row gap-3">                
                    <img :src="post.thumb" :alt="post.title" class="rounded w-full bg-gray-200"> 
                    <div class="flex justify-between w-full mb-2">
                        <div>
                            <span>Categoria:</span>
                            <Link class="ms-1 underline" :href="route('post.index', 'category/' + post.category.slug)">
                                {{ post.category.name }}
                            </Link>                
                        </div>       
                        <div class="">                 
                            <Link class="flex items-center active:scale-110" :href="route('like')" method="post" :data="{'post': post.id}" as="button">
                                <span :class="['material-icons',{ 'text-blue-500': post.like }]" translate="no">thumb_up</span>
                            </Link>                                                    
                        </div>
                    </div>
                </div>                
                <h1 class="w-auto text-4xl mb-2">{{ post.title }}</h1>
                <p>{{ post.content }}</p>       
                <h3 class="text-xl my-1">Comentários: </h3>
                <Comments :postId="post.id"></Comments>
            </div>

            <div class="w-full md:w-[25%] flex flex-col gap-5">
                <div class="flex flex-wrap w-full bg-white shadow sm:shadow-0 rounded p-3" 
                    v-for="post, key in post.related" :key="key"
                >   
                    <div class="w-full">
                        <img :src="post.thumb" :alt="post.title" class="w-full rounded">
                    </div>
                    <div>
                        <span> Categoria: </span>
                        <Link class="ms-1" :href="route('post.index', 'category/' + post.category.slug)">
                            {{ post.category.name }}
                        </Link>                
                    </div>
                    <div>
                        <span> Por: </span>                                                    
                        <Link class="ms-1" :href="route('post.index','author/' + post.user.name)">
                            {{ post.user.name }}
                        </Link>                
                    </div>                                         
                    <Link :href="route('post.show', post.slug)" class="underline">
                        {{ post.title }}
                    </Link>                    
                </div>
            </div>
        </div>        
    </DefaultLayout>
</template>
<script>    
    import DefaultLayout from '@/Layouts/DefaultLayout.vue';    
    import Comments from '@/Pages/Post/Partials/Comments.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';    
    import { Head, Link } from '@inertiajs/vue3';    

    export default {
        components: { DefaultLayout, PrimaryButton, Comments, Head, Link},
        props: ['post'],
        computed: {            
            likeRoute() {                
                return route('like');
            },            
            auth() {
                return this.$page.props.auth;
            }            
        }
    }
</script>
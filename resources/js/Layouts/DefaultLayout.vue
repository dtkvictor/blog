<template>
    <header class="flex justify-between items-center p-5 bg-neutral-900 shadow-md text-gray-100 gap-5">
        <Link :href="route('site.index')">
            <h1 class="h-10 font-bold text-2xl items-center lg:flex hidden">Coderunning</h1>            
        </Link>
        <div class="flex text-neutral-900 rounded-md bg-gray-100 sm:w-auto w-full">
            <input 
                type="search"                
                :placeholder="placeholder"
                v-model="searchText"
                class="bg-transparent border-none sm:w-auto w-full"                                
            >
            <Link :href="`${routeSearch}/${getSearchText()}`" class="flex justify-center items-center px-3 border-s min-w-[40px]">
                <span class="material-icons active:scale-75" translate="no">search</span>
            </Link>            
        </div>                        
        <Link v-if="!auth" :href="route('login')" class="flex justify-center items-center h-[40px] w-[40px]">            
            <span translate="no" class="material-icons text-gray-100 text-2xl">login</span>            
        </Link>
        <div v-else>
            <Dropdown></Dropdown>
        </div> 
    </header>
    <main class="w-full min-h-full bg-gray-100 p-5">
        <slot></slot>        
    </main>    
</template>

<script>
    import { Link } from '@inertiajs/vue3';    
    import Dropdown from '@/Layouts/Partials/Dropdown.vue';

    export default {        
        components: { Link, Dropdown },   
        props: ['placeholder', 'routeSearch'],
        data: () => ({
            searchText: '',                        
        }),        
        computed: {
            auth() {
                return this.$page.props.auth;
            }            
        },        
        methods: {
            getSearchText(){
                let search = this.searchText;
                search = search.replace(/ /g, '-');
                search = search.toLocaleLowerCase();
                return search;
            },            
        }
    }
</script>

<style scoped>
    .size-icons {
        font-size: 40px !important;
    }
</style>
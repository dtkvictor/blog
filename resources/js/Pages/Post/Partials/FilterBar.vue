<template>    
    <div :class="[
            'rounded shadow bg-white w-3/5 md:w-2/5 duration-500 p-3', 
            { 'overflow-hidden h-[48px]': !showFilters},
            { 'overflow-auto h-[400px]': showFilters }
    ]">
        <span>Filtrar por</span>
        <hr>
        <div class="mt-3">
            <ul v-if="authories.length >= 1">                     
                <h1>Author:</h1>
                <li v-for="author in authories" :key="author.id" class="flex items-center justify-between ms-2">
                    <Link 
                        :href="queryBuilder('author', author.slug)"
                        :class="['text-blue-500', {'text-purple-500': (urlQuery.get('author') == author.slug)}]"
                    >
                        {{ author.name }}
                    </Link>                        
                </li>                               
            </ul>

            <ul v-if="categories.length >= 1">                     
                <h1>Categoria:</h1>
                <li v-for="category in categories" :key="category.id" class="flex items-center justify-between ms-2">
                    <Link 
                        :href="queryBuilder('category', category.slug)" 
                        :class="['text-blue-500', {'text-purple-500': (urlQuery.get('category') == category.slug)}]"
                    >
                        {{ category.name }}
                    </Link>                        
                </li>                               
            </ul>
        </div>
        <Link :href="route('post.index')">Limpar filtros</Link>
    </div>
    <button class="m-3 flex items-center justify-center absolute" @click="showFilters = !showFilters">            
        <span v-if="!showFilters" class="material-icons">tune</span>
        <span v-else class="material-icons">close</span>            
    </button>                    
</template>
<script>
    import { Link } from '@inertiajs/vue3';
    import axios from 'axios';

    export default {
        components: { Link },
        data: () => ({
            urlQuery: new Map(),
            showFilters: false,
            categories: [],
            authories: []            
        }),
        mounted() {            
            this.getUrlQueries();
            this.getCategories();
            this.getAuthories();            
        },    
        methods: {            
            async getCategories() {
                let response = await axios.get(route('category.index'))
                if(response.status === 200) {
                    this.categories = await response.data.data;
                }                
            },
            async getAuthories() {
                let response = await axios.get(route('user.author'))
                if(response.status === 200) {
                    this.authories = await response.data.data;
                }                
            },     
            getUrlQueries() {
                let filters = location.href.split('filter/')[1];
                if(!filters) return;

                let arrayFilters = filters.split('/');

                for(let i = 0; i < arrayFilters.length; i+=2) {
                    if(!arrayFilters[i + 1]) continue;
                    let key = arrayFilters[i];
                    let value = arrayFilters[i + 1];
                    this.urlQuery.set(key, value);
                }
            },
            queryBuilder(field, value){                      
                const prefix = 'post/filter';
                const search = location.search;           
                let url = location.href.replace(search, '');

                if(!url.includes(prefix)) url += prefix;
                                
                if(!this.urlQuery.has(field)) {                    
                    return url + `/${field}/${value}`;
                }
                if(this.urlQuery.get(field) == value) {                    
                    return url.replace(`/${field}/${value}`, '');
                }                                
                return url.replace(this.urlQuery.get(field), value);
            },
        }
}
</script>
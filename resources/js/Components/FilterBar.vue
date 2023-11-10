<template>    
    <div class="w-3/5 md:w-2/5">
        <div class="rounded shadow bg-white duration-500 p-3 mb-1">
            <div class="flex justify-between">
                <span>Filtrar por</span>
                <button class="flex items-center justify-center" @click="openFilters" v-if="!data.showFilters">
                    <span class="material-icons" translate="no">tune</span>                    
                </button>                    
                <button class="flex items-center justify-center" @click="closeFilters" v-else>
                    <span class="material-icons" translate="no">close</span>            
                </button>
            </div>
        </div>
        
        <div :class="[
                'rounded shadow bg-white duration-500 p-3',                 
                { 'overflow-hidden h-[0px] opacity-0 py-0': !data.showFilters },
                { 'overflow-auto h-fit max-h-[300px] opacity-100': data.showFilters },
            ]">            
            <div class="w-full h-full">
                <div v-if="hiddenFilter('category')">
                    <h2 class="font-bold">Categorias: </h2>
                    <ul class="pl-5">
                        <li v-for="category in store.categories" :key="category.id" class="overflow-hidden">
                            <button 
                                :class="[activate('category', category.slug), 'hover:text-blue-500 truncate']"
                                @click="searchFilters('category', category.slug)"
                            >
                                {{ category.name }}
                            </button>
                        </li>
                    </ul>
                </div>

                <div v-if="hiddenFilter('author')">
                    <h2 class="font-bold">Autores: </h2>
                    <ul class="pl-5">
                        <li v-for="author in store.authories" :key="author.id"> 
                            <button 
                                :class="[activate('author', author.slug), 'hover:text-blue-500 truncate']"
                                @click="searchFilters('author', author.slug)"
                            >
                                {{ author.name }}
                            </button>
                        </li>
                    </ul>
                </div>

                <div v-if="hiddenFilter('orderBy')">
                    <h2 class="font-bold">Ordenar: </h2>
                    <ul class="pl-5">                    
                        <li v-for="orderBy, index in data.orderByFilters" :key="index">
                            <button 
                                :class="[activate('orderBy', orderBy.value), 'hover:text-blue-500']"
                                @click="searchFilters('orderBy', orderBy.value)"
                            >
                                {{ orderBy.name }}
                            </button>
                        </li>                        
                    </ul>
                </div>

                <div v-if="hiddenFilter('date')">
                    <label class="font-bold" for="date">Data:</label>                
                    <div class="flex justify-end w-full">
                        <input
                            @change="searchFilters('date', $event.target.value)"
                            :value="data.selected.get('date')"                            
                            id="date"
                            name="date"
                            type="date"
                            class="rounded-md"
                            style="width: calc(100% - 1.25rem);"
                        />  
                    </div>              
                </div>
                <div class="w-full my-3">
                    <button class="font-bold text-red-500" @click="clearFilters">Limpar filtros</button>                
                </div>
            </div>                
        </div>        
    </div>
</template>
<script setup>    
    import { router } from '@inertiajs/vue3';
    import { onBeforeMount, reactive } from 'vue';
    import Store from '@/Store/index.js';    

    const store = Store();

    const props = defineProps({
        filteringRoute: {
            type: String,
            required: true,
        },
        hidden: { 
            type: Array,
            default: [],
        },
        orderByFilters: {
            type: Array,
            default: []
        },
        contentHeight: {
            type: String,
            default: '400px'
        }
    })

    const data = reactive({
        classContentFilters: 'overflow-hidden h-[0px] opacity-0 py-0',
        showFilters: false,        
        selected: new Map(),        
        orderByFilters: [            
            { name: 'Criação', value: 'created' },
            { name: 'Atualização', value: 'updated' },            
        ]        
    });

    const activate = (field, value) => {
        if(data.selected.get(field) != value) return;
        return 'text-blue-500';
    }

    const setUrlQueries = () => {
        let filters = location.href.split('filter/')[1];
        if(!filters) return;

        const arrayFilters = filters.split('/');        
        for(let i = 0; i < arrayFilters.length; i += 2) {
            if(!arrayFilters[i + 1]) continue;
            let field = arrayFilters[i];
            let value = arrayFilters[i + 1];
            data.selected.set(field, value);            
        }
    }

    const searchFilters = (filter, content) => {
        let url = props.filteringRoute;        

        if(data.selected.get(filter) == content) {
            data.selected.delete(filter, content);        
        }else {
            data.selected.set(filter, content);
        }        

        for(const [field, value] of data.selected) {
            url += `/${field}/${value}`;
        }

        router.get(url);
    }

    const clearFilters = () => {
        const url = location.href.split('filter/')[0];
        router.get(url);
    }

    const hiddenFilter = (filter) => {
        if(props.hidden.includes(filter)) return false;
        return true;
    }

    const openFilters = () => {
        data.showFilters = true;        
    }

    const closeFilters = () => {
        data.showFilters = false;        
    }

    const setOrderByFilter = () => {
        data.orderByFilters.unshift(
            ...props.orderByFilters
        );
    }

    onBeforeMount(() => {        
        setUrlQueries();        
        setOrderByFilter();
    });

</script>

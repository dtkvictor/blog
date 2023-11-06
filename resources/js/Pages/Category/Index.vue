<template>
    <DefaultLayout placeholder="Apache2..." :routeSearch="route('category.filter') + '/name'">
        <Head title="Categorias"/>        
        <section class="flex flex-wrap justify-center gap-5">
            <div class="w-full md:w-3/5">
                <SubHeader class='mb-5' title="Categorias"></SubHeader>            
                <div class="relative flex justify-between gap-3 w-full mb-5">                                                                     
                    <CreateCategory btnClass="rounded-full"/>                                                
                    <FilterBar 
                        class="absolute right-0" 
                        contentHeight="200px"
                        :hidden="['category', 'author']" 
                        :filteringRoute="route('category.filter')"
                        :orderByFilters="orderByFilters"
                    />
                </div>                                
                <div v-for="category, index in categories" :key="index">
                    <div class="bg-white mb-5 rounded shadow p-3">
                        <div>                            
                            <p>Nome: {{ category.name }}</p>
                            <div class="flex gap-1">
                                <p>Descrição:</p> 
                                <p v-html="category.description"></p>                        
                            </div>                                
                            <p>Criado em: {{ localFormat(category.created_at) }}</p>
                            <p>Ultima atualização: {{ localFormat(category.updated_at) }}</p>                                                    
                        </div>
                        <div class="flex justify-end gap-1">            
                            <EditCategory :category="category" btnClass="rounded"/>
                            <DeleteCategory :category="category" btnClass="rounded"/>                            
                        </div>
                    </div>
                </div>
                <NotFound contentClass="md:w-full" v-if="categories.length < 1"/>
            </div>                
            <Pagination class="mt-[-1.25rem]" :links="links"/>  
        </section>
    </DefaultLayout>
</template>

<script>
    import DefaultLayout from '@/Layouts/DefaultLayout.vue';
    import Pagination from '@/Components/Pagination.vue';
    import SubHeader from '@/Components/SubHeader.vue';
    import DeleteCategory from './Partials/DeleteCategory.vue';
    import CreateCategory from './Partials/CreateCategory.vue';
    import EditCategory from './Partials/EditCategory.vue';
    import FilterBar from '@/Components/FilterBar.vue';
    import NotFound from '@/Components/NotFound.vue';
    import { Head, Link } from '@inertiajs/vue3';

    export default {        
        components: {
            DefaultLayout,            
            Pagination,
            SubHeader,
            DeleteCategory,
            CreateCategory,
            EditCategory,
            FilterBar,
            Head, Link,
            NotFound
        },
        props: ['response'],        
        data: () => ({
            orderByFilters: [
                { name: 'Alfabética', value: 'name' }
            ]
        }),
        methods: {
            localFormat(date) {
                let localFormat = new Date(date);
                return localFormat.toLocaleString('pt-Br');                
            } 
        },
        computed: {
            categories() {
                return this.response.data ?? []
            },
            links() {
                return this.response.links ?? []
            }
        }
    }
</script>
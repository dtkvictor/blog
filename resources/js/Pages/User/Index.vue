<template>
    <DefaultLayout>
        <Container title="Usuários" :paginationLinks="response.links">
            <div class="relative flex justify-end w-full mb-5 h-[48px]">
                <FilterBar class="absolute right-0"/>                
            </div>
            <div v-for="user, index in response.data" :key="index">
                <div class="w-full bg-white shadow rounded p-3 mb-5"> 

                    <div class="w-full flex flex-col mb-3">
                        <div class="flex justify-center md:justify-start">                             
                            <img class="rounded w-[100px] h-[100px]" :src="user.picture">
                        </div>
                        <ul>
                            <li class="flex flex-col md:flex-row">
                                <b class="mr-1">Nome:</b>
                                <p>{{ user.name }}</p>
                            </li>
                            <li class="flex flex-col md:flex-row">
                                <b class="mr-1">Email:</b> 
                                <p>{{ user.email }}</p>
                            </li>
                            <li class="flex flex-col md:flex-row">
                                <b class="mr-1">Administrador:</b> 
                                <p>{{ user.admin ? 'Sim' : 'Não' }}</p>
                            </li>
                            <li class="flex flex-col md:flex-row" v-if="user.admin">
                                <b class="mr-1">Quantidade de postagens:</b>                                
                                <p>{{ user.post_count }}</p>
                            </li>
                        </ul>                                                                                                                        
                        <!--Link 
                            class="text-blue-500 hover:underline"
                            v-if="user.post_count > 0" 
                            :href="route('user.show', user.id)"
                        >
                            Ver mais
                        </Link-->
                    </div>

                    <div class="flex justify-end gap-1">
                        <EditUser :user="user" btnClass="rounded"/>
                        <DeleteUser :user="user" btnClass="rounded"/>                    
                    </div>
                </div>
            </div>
        </Container>                
    </DefaultLayout>    
</template>
<script>

    import DefaultLayout from '@/Layouts/DefaultLayout.vue';
    import Container from '@/Components/Container.vue';   
    import FilterBar from '@/Components/FilterBar.vue';
    import EditUser from './Partials/EditUser.vue';
    import DeleteUser from './Partials/DeleteUser.vue';
    import { Link } from '@inertiajs/vue3';

    export default {        
        components: { 
            DefaultLayout,
            Container, 
            FilterBar,             
            EditUser, 
            DeleteUser, 
            Link
        },
        props: ['response'],
    }

</script>
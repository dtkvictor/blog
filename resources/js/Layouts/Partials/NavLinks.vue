<template>
    <nav :class="navClass ?? 'font-bold flex flex-col gap-3 p-3 text-neutral-900'">
        <Link :href="route('site.index')" :class="['flex gap-1 items-center hover:text-blue-500', actived('site.index')]">
            <span class='material-icons' translate="no">home</span>
            <p>Início</p>
        </Link>             
        <Link :href="route('profile')" :class="['flex gap-1 items-center hover:text-blue-500', actived('profile')]">
            <span class='material-icons' translate="no">person</span>
            <p>Perfil</p>
        </Link> 

        <div v-if="isAdmin">            
            <div class="flex gap-1 items-center mb-3 border-bottom">
                <span class="material-icons" translate="no">dashboard</span>
                <p>Admin: </p>
            </div>
            <div class="flex flex-col gap-3 ps-3">
                <Link :href="route('post.index')" :class="['flex gap-1 items-center hover:text-blue-500', actived('post.index')]">
                    <span class='material-icons' translate="no">feed</span>
                    <p>Postagens</p>
                </Link>         
                <Link :href="route('category.index')" :class="['flex gap-1 items-center hover:text-blue-500', actived('category.index')]">
                    <span class='material-icons' translate="no">category</span>
                    <p>Categorias</p>
                </Link>         
                <Link :href="route('user.index')" :class="['flex gap-1 items-center hover:text-blue-500', actived('user.index')]">
                    <span class='material-icons' translate="no">groups</span>
                    <p>Usuários</p>
                </Link>                                                        
            </div>
        </div>
        <Link :href="route('logout')" method="post" as="button" class="flex gap-1 items-center text-red-500 hover:text-blue-500">
            <span class='material-icons' translate="no">logout</span>
            <p>Sair</p>
        </Link>
    </nav>
</template>

<script>
    import { Link } from '@inertiajs/vue3';

    export default {
        components: { Link },
        props: ['navClass', 'activeColor'],
        methods: {
            actived(routeName) {                          
                const route = this.$page.props.current_page;                
                if(route == routeName) return this.activeColor ?? 'text-blue-500';
            }
        },
        computed: {
            isAdmin() {
                return this.$page.props.auth?.admin;
            },
        }


    }            
</script>
<template>
    <header class="flex justify-between items-center p-5 bg-neutral-900 shadow-md text-gray-100 gap-5">
        <Link :href="route('post.index')">
            <h1 class="h-10 font-bold text-2xl items-center lg:flex hidden">Coderunning</h1>
        </Link>
        <div class="flex text-neutral-900 rounded-md bg-gray-100 sm:w-auto w-full">
            <input 
                type="search"                
                placeholder="Install Lampp..."
                v-model="searchText" 
                class="bg-transparent border-none sm:w-auto w-full"                                
            >
            <Link :href="route('post.filter', 'title/' + searchTextWitoutSpace)" class="flex justify-center items-center px-3 border-s min-w-[40px]">
                <span class="material-icons" translate="no">search</span>
            </Link>
        </div>                    
        
        <Link v-if="!auth" :href="route('login')" class="flex justify-center items-center h-[40px] w-[40px]">            
            <span translate="no" class="material-icons text-gray-100 text-2xl">login</span>            
        </Link>

        <div v-else class="flex justify-center items-center gap-4 cursor-pointer" @click="showContainerAbsolute">
            <p class="font-bold text-lg items-center gap-1 md:flex hidden">
                <span v-if="auth.admin" class="material-icons" translate="no">verified_user</span> 
                {{ auth.name }}
            </p>
            <img class="w-10 h-10 rounded-full md:flex hidden" :src="auth.picture" alt="...">            

            <button class="sm:hidden flex bg-gray-100 p-2 rounded">
                <span class="material-icons-round text-neutral-900" translate="no">menu</span>
            </button>

        </div>        
    </header>
    <main class="w-full min-h-full bg-gray-100 p-5">
    <Transition>
        <div class="container-absolute duration-500" v-if="visibleContainerAbsolute" @click="hiddenContainerAbsolute">
            <div class="bg-gray-200 md:w-3/12 w-9/12 h-full">
                <header class="shadow flex flex-wrap">
                    <div class="w-full justify-end items-center p-5 sm:flex hidden">
                        <span class="material-icons cursor-pointer p-2" @click="hiddenContainerAbsolute">
                            close
                        </span>
                    </div>

                    <div class="w-full flex flex-wrap justify-center items-center h-[80px] md:hidden" v-if="auth">                        
                        <img class="w-10 h-10 rounded-full" :src="auth.picture" alt="...">                                                            
                        <div class="w-full flex justify-center items-center">
                            <span v-if="auth.admin" class="material-icons" translate="no">verified_user</span> 
                            <p class="truncate">                                
                                {{ auth.name }}
                            </p>                        
                        </div>
                    </div>                    
                </header>
                <ul>
                    <li class="p-3 hover:bg-gray-300">
                        <Link :href="route('profile')" class="flex items-center gap-1">
                            <span translate="no" class="material-icons">person</span>
                            Perfil
                        </Link>
                    </li>                                                                                                                      
                    
                    <li class="p-3 hover:bg-gray-300">
                        <Link :href="route('logout')" method="post" class="flex items-center gap-1 text-red-400">
                            <span translate="no" class="material-icons">logout</span>
                            Logout
                        </Link>
                    </li>            
                </ul>
            </div>
        </div>
    </Transition>            
        <slot></slot>
    </main>    
</template>

<script>
    import { Link, router } from '@inertiajs/vue3';

    export default {        
        components: { Link },        
        data: () => ({
            searchText: '',            
            visibleContainerAbsolute: false,            
        }),        
        computed: {
            auth() {
                return this.$page.props.auth;
            },            
            searchTextWitoutSpace() {
                return this.searchText.replace(/\s+/g, '-');
            }
        },
        methods: {
            showContainerAbsolute() {                   
                this.visibleContainerAbsolute = true;
            },
            hiddenContainerAbsolute() {                
                this.visibleContainerAbsolute = false;
            }            
        }
    }
</script>
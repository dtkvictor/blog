<template>    
    <div class="w-full flex mb-3 gap-3 duration-1000">                            
        <img class="w-[50px] h-[50px] rounded-full" :src="comment.user.picture">
        <div class="rounded bg-gray-200 w-full flex justify-between p-1 ps-3 pe-3 ">
            <div class="flex flex-col">                            
                <p class="">{{ comment.user.name }}</p>                                                    
                <p class="">{{ comment.text }}</p>
            </div>
            <div class="flex gap-3" v-if="auth && auth.id === comment.user.id && showActions == true">
                <button class="flex justify-center items-center" @click="actionEdit(comment)">
                    <span class="material-icons text-yellow-500 hover:drop-shadow-md active:scale-75" translate="no">edit</span>
                </button>
                <button class="flex justify-center items-center" @click="actionDelete(comment.id)">
                    <span class="material-icons text-red-500 hover:drop-shadow-md active:scale-75" translate="no">delete</span>                                                                                         
                </button>
            </div>
        </div>                                            
    </div>                                                
</template>

<script>
    export default {        
        props: {
            comment: {default: null},
            actionEdit: {default: null},
            actionDelete: {default: null},
            showActions: {type: Boolean, default: true}
        },
        computed: {
            auth() {
                return this.$page.props.auth;
            }, 
        }
    }
</script>
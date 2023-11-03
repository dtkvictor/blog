<template>
    <div class="w-full flex justify-between items-center rounded">
        <h1 class="text-lg text-bold uppercase">{{ title }}</h1>                             
        <img :src="user.picture" class="w-[50px] h-[50px] rounded-full shadow">                                
    </div>
</template>

<script>
    export default {
        props: ['title'],
        computed: {
            user() {
                return this.$page.props.auth;
            }
        }
    }
    
</script>
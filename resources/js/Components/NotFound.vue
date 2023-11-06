<template>
    <div class="flex justify-center w-full">
        <div :class="['flex flex-wrap w-full md:w-3/4 rounded shadow bg-white p-5 text-neutral-900', contentClass]">                        
            <div class="w-full md:w-2/4">
                <h1 class="text-6xl font-bold">Oops!</h1>                
                <h2 class="text-3xl">Parece não ter nada por aqui.</h2>
            </div>
            <div class="w-full md:w-2/4 aspect-[1/1] cat-background"></div>
        </div>
    </div>
</template>
<script setup>
    defineProps({
        contentClass: String,
    })
</script>
<style scoped>
    .cat-background {
        display: flex;        
        justify-content: center;
        background-color: white;
        background-image: url('/assets/image/cat.gif');   
        background-size: contain;     
        background-position-y: -2rem;
    }
</style>

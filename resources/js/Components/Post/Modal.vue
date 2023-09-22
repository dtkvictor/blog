<template>
   <div class="container-absolute flex justify-center items-center" v-if="showModal">
        <div class="bg-white w-full h-full sm:w-3/5 sm:h-4/5 sm:rounded p-5">
            <div class="flex w-100 justify-between mb-3">
                <h3 class="text-xl">{{ title }} </h3>
                <button @click="$emit('closeModal')" class="material-icons">close</button>
            </div>                   
            <slot name="content"></slot>                            
        </div>
   </div>
</template>
<script>
    export default {
        props: {
            title: String,
            showModal: Boolean
        }
    }
</script>
<template>
    <div class="rounded w-full p-5 bg-gray-200" :id="id">                        
        <div class="flex justify-between gap-3">
            <textarea class="w-full rounded" v-model.lazy="data.text" rows="1"></textarea>
            <PrimaryButton @click="submit">{{ btnName }}</PrimaryButton>
        </div>                        
    </div>
</template>
<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { reactive, onBeforeMount } from 'vue';
    import { router } from '@inertiajs/vue3';
    import iziToast from 'izitoast';

    const props = defineProps({
        id: String,
        default: String,
        btnName: String,        
        routeName: String,
        method: String,
        postId: Number,
        clear: Boolean
    });

    const data = reactive({
        text: null,
    });

    const submit = () => {        
        if(!data.text) return;
        if(data.clear) data.text = null;

        router.visit(props.routeName, {
            method: props.method,
            preserveScroll: true,
            data: {
                post: props.postId,
                text: data.text
            },        
            onSuccess: () => {
                iziToast.success({
                    title: 'Sucesso!',
                    message: ""
                })
            },
            onError: errors => {
                for (let erro in errors) {
                    iziToast.error({
                        title: 'Error!',
                        message: errors[erro]
                    })   
                }                
            },        
        });        
    }
        
    onBeforeMount(() => {
        data.text = props.default;
    });    
</script>
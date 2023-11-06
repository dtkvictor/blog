<template>    
    <ModalComment :show="show" @close="emits('close')" contentHeight="h-full">
        <div class="bg-white w-full h-full sm:rounded p-5">
            <div class="flex w-100 justify-between mb-3">
                <h3 class="text-xl">Comentários: </h3>
                <button @click="$emit('close')" class="material-icons">close</button>
            </div>                   
            <div class="overflow-y-auto overflow-x-hidden h-3/4 px-3" @scroll="lazyLoadComments($event)">
                <LoadComment amount="6" v-if="data.comments < 1"/>
                <CardComment 
                    v-for="comment in data.comments"
                    :key="comment.id"
                    :comment="comment"        
                    :auth="auth"
                    @editComment="emits('editComment', $event)"
                    @deleteComment="emits('deleteComment', $event)"
                />                    
            </div>
            <InputComment 
                btnName="Enviar"
                method="post"
                :postId="postId"
                :routeName="route('comments.create')"
            />            
        </div>                        
    </ModalComment>            
</template>
<script setup>
    import ModalComment from '@/Components/Modal.vue';
    import CardComment from './Card.vue';
    import LoadComment from './CardLoading.vue';
    import InputComment from './Input.vue';    
    import { reactive, defineEmits, onBeforeMount } from 'vue';
    import axios from 'axios';

    const props = defineProps({
        show: Boolean,
        postId: Number,
        auth: { type: Object, required: true }
    });       

    const emits = defineEmits(['close', 'editComment', 'deleteComment']);

    const data = reactive({
        comments: [],
        currentPage: 1,   
        lastPage: 1,
        fetch: false,
    })

    const lazyLoadComments = async (event) => {
        const { scrollTop, scrollTopMax } = event.target;
        if(!(scrollTop >= scrollTopMax)) return;        
        if(data.currentPage > data.lastPage) return;
        if(data.fetch) return fetchComments();        
    }

    const fetchComments = async () => {
        data.fetch = false;

        const page = route('api.comments', [props.postId, { 'page': data.currentPage }]);        
        const response = (await axios.get(page)).data;

        data.comments.push(...(await response.data));
        data.currentPage = await response.meta.current_page;
        data.lastPage = await response.meta.last_page;        

        if(data.currentPage < (data.lastPage + 1)) {
            data.currentPage ++;
        }

        data.fetch = true;
    }    

    onBeforeMount(() => {
        fetchComments();
    });    
</script>
<template>
    <Modal :show="show">
        <div class="w-full h-full flex flex-col p-3  gap-3">                    
            <div class="w-full flex items-center justify-between">
                <h1 class="text-3xl mb-3 font-light">Editar comentário</h1>
                <button class="material-icons" @click="emits('close')">close</button>
            </div>
            <div class="w-full flex items-center overflow-hidden gap-3">
                <img class="w-[60px] h-[60px] rounded-full" :src="comment.user.picture">
                <h3 class="w-full truncate underline">{{ comment.user.name }}</h3>
            </div>                            
            <div class="w-full flex items-center justify-center gap-3">                
                <InputComment
                    btnName="Atualizar"
                    method="put"
                    :default="comment.text"
                    :postId="comment.post"
                    :routeName="route('comments.update', comment.id)"
                />
            </div>
        </div>            
    </Modal>
</template>
<script setup>
    import Modal from '@/Components/Modal.vue';
    import InputComment from './Input.vue';
    import { defineEmits } from 'vue';

    const props = defineProps({
        show: Boolean,
        comment: Object,        
    });

    const emits = defineEmits(['close'])
</script>
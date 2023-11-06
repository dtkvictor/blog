<template>
    <AllComments 
        :postId="postId" 
        :show="data.showComments" 
        :auth="auth"
        @close="closeModalComments"
        @editComment="openEditComment($event)"
        @deleteComment="openDeleteComment($event)"
    />

    <CardComment 
        v-for="comment in comments"
        :key="comment.id"
        :comment="comment"        
        :auth="auth"
        @editComment="openEditComment($event)"
        @deleteComment="openDeleteComment($event)"
    />

    <InputComment 
        btnName="Enviar"                 
        method="post"
        :postId="postId"
        :routeName="route('comments.create')"        
    />

    <EditComment 
        :show="data.editComment.show"
        :comment="data.editComment.comment"
        @close="closeEditComment"
    />
    
    <DeleteComment 
        messageSuccess="Comentário apagado com sucesso!"
        messageFails="Falha ao apagar o comentário"
        :show="data.deleteComment.show"        
        :showButton="false"        
        :preserveScroll="true"
        :routeName="route('comments.destroy', data.deleteComment.comment ?? 0)"
        @close="closeDeleteComment"
    >
        <template #title>
            <h1 class="text-3xl mb-3 font-light">Apagar comentário</h1>
        </template>
        <template #content>
            Após confirmar, <b>essa ação não poderá ser desfeita</b>, você realmente deseja
            apagar esse comentário?
        </template>
    </DeleteComment>

    <button class="underline" @click="openModalComments">
        Exibir mais
    </button>
</template>

<script setup>
    import CardComment from './Comments/Card.vue';    
    import InputComment from './Comments/Input.vue';            
    import AllComments from './Comments/AllComments.vue';
    import EditComment from './Comments/EditComment.vue';
    import DeleteComment from '@/Components/Actions/Delete.vue';
    import { reactive } from 'vue';

    const props = defineProps({
        comments: Object,        
        postId: Number,   
        auth: { type: Object, required: true }
    });

    const data = reactive({
        showComments: false,      
        editComment: {
            show: false,
            comment: {}
        },
        deleteComment: {
            show: false,
            comment: null 
        }
    });

    const openModalComments = () => {
        data.showComments = true;
    }

    const closeModalComments = () => {
        data.showComments = false;
    }

    const openEditComment = (comment) => {
        data.editComment.show = true;
        data.editComment.comment = comment;
    } 

    const closeEditComment = () => {
        data.editComment.show = false;
    } 

    const openDeleteComment = (comment) => {
        data.deleteComment.show = true;
        data.deleteComment.comment = comment.id;
    } 

    const closeDeleteComment = () => {
        data.deleteComment.show = false;
    } 
</script>
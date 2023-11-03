<template>
    <ActionDelete
        btnClass="rounded"                                                                        
        :routeName="route('post.destroy', post.id)"
        :messageSuccess="`Postagem: ${post.title} deletada com sucesso!`"
        :messageFails="`Falha ao deletar ${post.title}`"
    >
        <template #title>
            <h1 class="text-3xl mb-3 font-light">Deletar Postagem</h1>
        </template>
        <template #content>
            Após confirmar, <b>essa ação não poderá ser desfeita</b>, você realmente deseja
            deletar essa postagem?
        </template>
    </ActionDelete>
</template>
<script setup>
    import ActionDelete from '@/Components/Actions/Delete.vue'
    defineProps({
        post: Object
    });        
</script>
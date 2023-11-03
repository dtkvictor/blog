<template>    
    <ActionDelete
        :btnClass="btnClass"
        :routeName="route('user.destroy', user.id)"
        :messageSuccess="`Usuário: ${user.name} deletada com sucesso!`"
        :messageFails="`Falha ao deletar a categoria ${user.name}`"                                
    >
        <template #title>
            <h1 class="text-3xl mb-3 font-light">Deletar Usuário</h1>             
        </template>
        <template #content>
            Você realmente deseja deletar esse usuário: <b>{{ user.name }}</b>?
            Após a confirmação essa ação não poderá ser desfeita.
        </template>
    </ActionDelete>
</template>
<script>
    import ActionDelete from '@/Components/Actions/Delete.vue'
    export default {
        components: { ActionDelete },
        props: ['user', 'btnClass']
    }
</script>
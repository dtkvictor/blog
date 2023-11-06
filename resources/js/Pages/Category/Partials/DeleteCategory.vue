<template>
    <ActionDelete
        :btnClass="btnClass"
        :routeName="route('category.destroy', category.id)"
        :messageSuccess="`Categoria: ${category.name} deletada com sucesso!`"
        :messageFails="`Falha ao deletar a categoria ${category.name}`"
        @success="store.refreshCategory()"
    >
        <template #title>
            <h1 class="text-3xl mb-3 font-light">Deletar categoria</h1>             
        </template>
        <template #content>
            Você realmente deseja deletar a categoria: <b>{{ category.name }}</b>?
            Após confirmar, <b>essa ação não poderá ser desfeita</b>, você realmente deseja
            deletar essa categoria?
        </template>
    </ActionDelete>
</template>
<script setup>
    import ActionDelete from '@/Components/Actions/Delete.vue'
    import Store from '@/Store';
    const store = Store();
    const props = defineProps(['category', 'btnClass']);
</script>
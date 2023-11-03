<template>
    <button :class="['bg-red-500 flex justify-center itens-center p-3 shadow', btnClass]" @click="openActionModal">
        <span class="material-icons" translate="no">delete</span>
    </button>
    <DialogModal :show="data.showActionModal" @close="closeActionModal">
        <template #title>
            <slot name="title"></slot>
        </template>

        <template #content>
            <slot name="content"></slot>
        </template>

        <template #footer>
            <SecondaryButton @click="closeActionModal">
                Cancelar
            </SecondaryButton>
            <DangerButton class="ml-3" @click="actionDelete">
                Deletar
            </DangerButton>
        </template>        
    </DialogModal>
</template>
<script setup>
    import { router } from '@inertiajs/vue3';
    import DialogModal from '@/Components/DialogModal.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import iziToast from 'izitoast';
    import { reactive } from 'vue';

    const props = defineProps({
        btnClass: String,
        routeName: String,            
        messageSuccess: String,
        messageFails: String,            
    })

    const data = reactive({
        showActionModal: false,
    })

    const openActionModal = () => {
        data.showActionModal = true;
    } 

    const closeActionModal = () => {
        data.showActionModal = false;
    } 

    const success = () => {
        iziToast.success({
            title: 'Sucesso!',
            message: props.messageSuccess ?? ''
        });
        closeActionModal()
    }

    const fails = (response) => {        
        iziToast.error({            
            title: 'Erro!',
            message: response.erro
        });
        closeActionModal()
    }
    const actionDelete = () => {                
        router.delete(props.routeName, {                    
            onSuccess: () => success(),
            onError: response => fails(response)
        });
    }    
</script>

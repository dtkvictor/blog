<template>
    <button 
        v-if="showButton"
        :class="['bg-red-500 flex justify-center itens-center p-3 shadow', btnClass]" 
        @click="openActionModal">
        <span class="material-icons" translate="no">delete</span>
    </button>
    <DialogModal :show="showActionModal" @close="closeActionModal">
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
    import { reactive, defineEmits, computed } from 'vue';

    const props = defineProps({
        btnClass: String,
        routeName: String,            
        messageSuccess: String,
        messageFails: String,  
        preserveScroll: { type: Boolean, default: false },   
        show: { type: Boolean },
        showButton: { type: Boolean, default: true }        
    });

    const emit = defineEmits(['success', 'fails', 'close']);

    const data = reactive({
        showActionModal: false,
    });

    const openActionModal = () => {
        data.showActionModal = true;
    }

    const closeActionModal = () => {
        data.showActionModal = false;
        emit('close');
    } 

    const showActionModal = computed(() => {
        if(props.show || data.showActionModal) return true;
        return false;
    })

    const success = () => {
        iziToast.success({
            title: 'Sucesso!',
            message: props.messageSuccess ?? ''
        });
        emit('success')
        closeActionModal()
    }

    const fails = (response) => {        
        iziToast.error({            
            title: 'Erro!',
            message: response.erro
        });
        emit('fails')
        closeActionModal()
    }

    const actionDelete = () => {                
        router.delete(props.routeName, {
            preserveScroll: props.preserveScroll,            
            onSuccess: () => success(),
            onError: response => fails(response)
        });
    }    

</script>

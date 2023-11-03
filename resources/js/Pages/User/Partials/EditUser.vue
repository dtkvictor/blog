<template>    
    <button :class="['bg-yellow-500 flex justify-center itens-center p-3 shadow', btnClass]" @click="openModal">
        <span class="material-icons" translate="no">edit</span>
    </button>
    <Modal :show="data.showModalEdit" @close="closeModal">                    
        <Form             
            :routeName="route('user.update', user.id)"
            :user="user"             
            :success="success" 
            :fails="fails"        
        >
            <template #header>
                <div class="w-full flex justify-between items-center">
                    <h1 class="text-3xl mb-3 font-light">Editar Usuário</h1>                    
                    <button class="material-icons" translate="no" @click="closeModal">
                        close
                    </button>
                </div>                
            </template>
        </Form>
    </Modal>    
</template>
<script setup>
import Modal from '@/Components/Modal.vue';
import Form from './Form.vue';
import iziToast from 'izitoast';
import { reactive } from 'vue';

const props = defineProps({
    btnClass: String,
    user: Object
});

const data = reactive({
    showModalEdit: false
});

const openModal = () => {
    data.showModalEdit = true    
};

const closeModal = () => {
    data.showModalEdit = false
};

const success = () => {
    iziToast.success({
        'title': 'Sucesso!',
        'message': 'Informações do usuário atualizadas com sucesso.'
    });
}
</script>
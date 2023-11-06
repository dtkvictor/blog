<template>    
    <button :class="['bg-yellow-500 flex justify-center itens-center p-3 shadow', btnClass]" @click="openModal">
        <span class="material-icons" translate="no">edit</span>
    </button>
    <Modal :show="data.showModalCreate" @close="closeModal">                    
        <Form 
            method="put"
            :routeName="route('category.update', category.id)"
            :category="category"
            :success="success"            
            @updated="store.updateCategory($event)"
        >
            <template #header>
                <div class="w-full flex justify-between items-center">
                    <h1 class="text-3xl mb-3 font-light">Editar categoria</h1>                    
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
import Store from '@/Store';

const store = Store();

const props = defineProps({
    btnClass: String,
    category: Object
});

const data = reactive({
    showModalCreate: false
});

const openModal = () => {
    data.showModalCreate = true    
};

const closeModal = () => {
    data.showModalCreate = false
};

const success = () => {
    iziToast.success({
        'title': 'Sucesso!',
        'message': 'Categoria atualizada com sucesso.'
    });
}
</script>
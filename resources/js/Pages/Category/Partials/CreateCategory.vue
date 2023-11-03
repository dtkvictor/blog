<template>    
    <button :class="['bg-white flex justify-center itens-center p-3 shadow', btnClass]" @click="openModal">
        <span class="material-icons" translate="no">add</span>
    </button>
    <Modal :show="data.showModalCreate" @close="closeModal">            
        <Form 
            method="post" 
            :routeName="route('category.store')"
            :category="[]"             
            :success="success" 
            :fails="fails"
            :clear="true"
        >
            <template #header>
                <div class="w-full flex justify-between items-center">
                    <h1 class="text-3xl mb-3 font-light">Nova categoria</h1>                    
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
import Form from '@/Pages/Category/Partials/Form.vue';
import iziToast from 'izitoast';
import { reactive } from 'vue';

const props = defineProps({
    btnClass: String,
    category: Array
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
        'message': 'Categoria criada com sucesso.'
    });
}
</script>
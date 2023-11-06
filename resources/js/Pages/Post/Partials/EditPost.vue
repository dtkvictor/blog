<template>
    <button :class="['bg-yellow-500 flex justify-center itens-center p-3 shadow', btnClass]" @click="showModalEdit = true">
        <span class="material-icons" translate="no">edit</span>
    </button>
    <Modal :show="showModalEdit" @close="showModalEdit = false">
        <Form 
            method="put"
            success="Postagem atualizada com sucesso!"
            :post="post"            
            :routeName="route('post.update', post.id)"
        >
            <template #header>
                <div class="w-full flex justify-between items-center">
                    <h1 class="text-3xl mb-3 font-light">Editar postagem</h1>                    
                    <button class="material-icons" translate="no" @click="showModalEdit = false">
                        close
                    </button>
                </div>                
            </template>
        </Form>
    </Modal>
</template>
<script>
    import Modal from '@/Components/Modal.vue';
    import Form from '@/Pages/Post/Partials/Form.vue';

    export default {        
        components: { Modal, Form },
        props: ['btnClass', 'post'],
        data: () => ({
            showModalEdit: false,            
        })        
    }
</script>
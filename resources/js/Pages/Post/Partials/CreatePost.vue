<template>    
        <button :class="['bg-white flex justify-center itens-center p-3 shadow', btnClass]" @click="showModalEdit = true">
            <span class="material-icons" translate="no">add</span>
        </button>
        <Modal :show="showModalEdit" @close="showModalEdit = false">            
            <Form                 
                method="post"
                :routeName="route('post.store')"
                :success="success" 
                :clear="true"                
            >
                <template #header>
                    <div class="w-full flex justify-between items-center">
                        <h1 class="text-3xl mb-3 font-light">Nova postagem</h1>                    
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
        props: ['btnClass'],
        data: () => ({
            showModalEdit: false,
            success: "Postagem realizada com sucesso!"
        }),        
    }
</script>
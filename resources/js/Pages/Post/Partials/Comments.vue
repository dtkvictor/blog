<template>
    <Transition>
        <ModalComment :showModal="showComments" @closeModal="showComments = false" title="Comentários: ">
            <template v-slot:content>
                <div class="overflow-y-auto overflow-x-hidden h-3/4 px-3" @scroll="lazyLoadComments($event)">
                    <CardComment 
                        v-for="comment in storageComments" 
                        :key="comment.id" 
                        :comment="comment"
                        :actionDelete="alertDeleteComment"
                        :actionEdit="showModalEditComment"
                    />                                            
                </div>
                <inputComment btnName="Enviar" @text="textComment = $event" :action="sendMessage"/>
            </template>
        </ModalComment>        
    </Transition>        
    <Modal :show="edit.show">                        
        <div class="w-full h-full flex flex-col p-3  gap-3">                    
            <div class="w-full flex items-center justify-between">                    
                <p>{{ edit.comment.user.name }}</p>
                <button class="material-icons" @click="edit.show = false">close</button>
            </div>
            <div class="w-full flex items-center justify-center gap-3">
                <img class="w-[60px] h-[60px] rounded-full" :src="edit.comment.user.picture">
                <inputComment 
                    btnName="Editar" 
                    @text="edit.comment.text = $event"
                    :default="edit.comment.text"
                    :action="editComment"
                />
            </div>
        </div>            
    </Modal>

    <CardComment 
        v-for="comment in getComments" 
        :key="comment.id"
        :comment="comment"
        :actionDelete="alertDeleteComment"
        :actionEdit="showModalEditComment"
    />
    <inputComment btnName="Enviar" :text="textComment" @text="textComment = $event" :action="sendMessage" />
    <button class="underline" @click="showComments = true">
        Exibir mais
    </button>
</template>

<script>
    import CardComment from './Comments/Card.vue';
    import ModalComment from '@/Components/Post/Modal.vue';
    import InputComment from './Comments/Input.vue';
    import Modal from '@/Components/Modal.vue';
    import { router } from '@inertiajs/vue3';

    export default {
        components: { CardComment, InputComment, ModalComment, Modal },
        props: ['postId'],        
        data: () => ({
            edit: {
                show: false,                             
                comment: '',
            },
            textComment: '',
            showComments: false,                        
            storageComments: [],            
            currentPage: null,
            lastPage: null,               
        }),        
        mounted() {
            this.loadComments();
        },
        computed: {            
            getComments() {
                return this.storageComments.slice(0, 5);
            }
        },
        methods: {
            async loadComments() {                
                let page = this.currentPage ? this.currentPage + 1 : 1;
                if(this.lastPage && page > this.lastPage) return;                                

                let response = await axios(route('comments.show', [this.postId, {page: page}]));
                if(response.status == 200) {
                    this.currentPage = response.data.meta.current_page;
                    this.lastPage = response.data.meta.last_page; 
                    this.storageComments = this.storageComments.concat(response.data.data);
                }                
            },
            lazyLoadComments(event) {
                let max = event.target.scrollTopMax;
                let current = event.target.scrollTop;
                if(current == max) this.loadComments();
            },            
            sendMessage() {
                if(!this.$page.props.auth) return router.get(route('login'));
                if(!this.textComment) return;

                axios.post(route('comments.store'), {
                    text: this.textComment,
                    post: this.postId
                })
                .then(response => {                    
                    this.$iziToast.success({
                        title: 'Sucesso',
                        message: 'Comentário enviado com sucesso.'
                    });
                    this.storageComments.unshift(response.data.data)
                })
                .catch(error => {                    
                    this.$iziToast.error({
                        title: "Erro",
                        message: "Falha ao enviar o comentário."
                    })
                })   
                this.textComment = '';
            },           
            alertDeleteComment(commentId) {                               
                const deleteComment = this.deleteComment;
                return this.$iziToast.question({
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: commentId,
                    zindex: 999,
                    title: 'Aviso',
                    message: 'Deseja mesmo apagar esse comentário?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', 
                        function (instance, toast) {
                            deleteComment(commentId);
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }, true],
                        ['<button>NO</button>', 
                        function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }],
                    ]                    
                });
            },
            deleteComment(commentId) {
                if(this.storageComments.length <= 5) this.loadComments();

                axios.delete(route('comments.destroy', commentId))
                    .then(() => {
                        this.storageComments = this.storageComments.filter(
                            comment => comment.id != commentId
                        );
                        this.$iziToast.success({
                            title: 'Sucesso',
                            message: 'Comentário deletado com sucesso.'
                        })
                    })
                    .catch(() => {
                        this.$iziToast.error({
                            title: 'Erro',
                            message: 'Não foi possível deletar esse comentário.'
                        })
                    })
            },
            showModalEditComment(comment) {
                this.edit.show = true;
                this.edit.comment = comment;
            },
            editComment() {                
                axios.patch(route('comments.update', this.edit.comment.id), {
                    text: this.edit.comment.text
                })
                .then(() => {
                    let index = this.storageComments.findIndex(
                        comment => comment.id == this.edit.comment.id
                    );  
                    this.storageComments[index].text = this.edit.comment.text;
                    this.edit.show = false;                              
                    this.edit.comment = '';

                    this.$iziToast.success({
                        title: 'Sucesso',
                        message: 'Comentário editado com sucesso.'
                    })
                })
                .catch((erro) => {
                    console.log(erro)
                    this.$iziToast.error({
                        title: 'Erro',
                        message: 'Falha ao editar o comentário'
                    })
                });                
            } 

        }        
    }
</script>
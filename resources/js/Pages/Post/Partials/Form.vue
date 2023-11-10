<template>        
    <section class="w-full flex justify-center">
        <div class="w-full p-5 bg-white rounded">            
            <slot name="header"></slot>
            <div class="mb-3">
                <InputLabel value="Thumb" />
                <InputFile                              
                    name="thumb"
                    :default="post?.thumb ?? '/assets/image/upload.jpg'"                    
                    imgClass="w-60 h-60 opacity-[90%] hover:opacity-75 rounded"                            
                    @binaryFile="form.thumb = $event"
                    @clearImage="form.clearImage = $event"
                />                        
                <InputError class="mt-2" :message="form.errors.thumb" />
            </div>
                                
            <div class="mb-4 w-full">                        
                <InputLabel for="category" value="Categoria"/>
                <div class="flex gap-3">
                    <select class="rounded border-gray-300 w-full md:w-auto" name="category" v-model="form.category">
                        <option 
                            v-for="category, index in store.categories" :key="index"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>                                        
                </div>
                <InputError class="mt-2" :message="form.errors.category" />                                                                                                    
            </div>

            <div>
                <InputLabel for="title" value="Título" />
                <TextInput
                    id="titulo"
                    v-model="form.title"
                    type="text"
                    class="mt-1 block w-full border-gray-300"                            
                    autofocus                            
                />
                <InputError class="mt-2" :message="form.errors.title" />
            </div>

            <div class="mt-4">
                <InputLabel for="content" value="Contéudo" />
                <QuillEditor 
                    contentType="html"
                    theme="snow"
                    :content= "form.content"                    
                    v-model:content= "form.content"             
                    ref="quillContent"                    
                />                
                <InputError class="mt-2" :message="form.errors.content" />
            </div>                                                                                      

            <div class="flex items-center justify-end mt-4">                        
                <PrimaryButton :class="['ml-4 bg-neutral-900', { 'opacity-25': form.processing }]" @click="submit">
                    Postar
                </PrimaryButton>                
            </div>            
            
        </div>            
    </section>    
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputFile from '@/Components/Form/InputFile.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import { router } from '@inertiajs/vue3';
import { defineComponent, reactive, ref } from 'vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

import iziToast from 'izitoast';
import Store from '@/Store/index.js';

const store = Store();
const quillContent = ref(null);

const props = defineProps({
    post: { type: Object, default: {}},
    routeName: String,
    method: String,
    success: String,
    fails: String,
    clear: Boolean
});

const form = reactive({
    _method: props.method,
    title: props.post?.title ?? '',
    thumb: '',
    content: props.post?.content ?? '',
    category: props.post?.category?.id ?? store.firstCategory?.id,
    errors: {},    
    clearImage: null,
});

const formClear = () => {
    form.title = '',
    form.thumb = '',
    form.content = '',
    form.category = store.firstCategory.id,
    quillContent.value.setHTML('')
    form.errors = {}
    if(form.clearImage) {
        form.clearImage();
    }
}

const submit = () => {
    router.post(props.routeName, form, {                
        preserveState: true,
        onSuccess: () => {
            iziToast.success({
                title: "Sucesso!",
                message: props.success,
            });
            if(props.clear) {
                formClear();
            }
        },
        onError: errors => {
            form.errors = errors;                               
        }
    });    
}

defineComponent('QuillEditor', QuillEditor);
</script>

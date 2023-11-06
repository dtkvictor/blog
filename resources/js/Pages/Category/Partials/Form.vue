<template>        
    <section class="w-full flex justify-center">
        <div class="w-full p-5 bg-white rounded">            
            <slot name="header"></slot>                        

            <div>
                <InputLabel for="name" value="Nome" />
                <TextInput
                    id="titulo"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full border-gray-300"                            
                    autofocus                            
                />
                <InputError class="mt-2" :message="data.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="description" value="Descrição" />
                <QuillEditor 
                    ref="quillContent"
                    contentType="html"
                    :content="form.description"
                    theme="snow" v-model:content="form.description"                    
                />
                <InputError class="mt-2" :message="data.errors.description" />
            </div>                                                                                      

            <div class="flex items-center justify-end mt-4">                        
                <PrimaryButton :class="['ml-4 bg-neutral-900', { 'opacity-25': form.processing }]" @click="submit">
                    Salvar
                </PrimaryButton>
            </div>            
        </div>            
    </section>    
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import { useForm, router } from '@inertiajs/vue3';
import { defineComponent, reactive, defineEmits, ref } from 'vue';
import { QuillEditor } from '@vueup/vue-quill'

import '@vueup/vue-quill/dist/vue-quill.snow.css';

const quillContent = ref(null);

const emits = defineEmits(['created', 'updated']);

const data = reactive({
    errors: {},
})

const props = defineProps([
    'routeName',
    'method',
    'category',
    'success',
    'fails',    
    'clear',
]);

const form = useForm({
    name: props.category?.name ?? '',    
    description: props.category?.description ?? '',
});

const formClear = () => {
    form.name = '',
    form.description = ''
    quillContent.value.setHTML('')
    data.errors = {}
}

const emit = {
    post: () => emits('created'),
    put: () => emits('updated', { ...props.category, ...form }),
    patch: () => emits('updated', { ...props.category, ...form })
}

const submit = () => {        
    router.visit(props.routeName, {
        method: props.method,
        data: form,
        preserveState: true,

        onSuccess: response => {
            if(props.success) {                
                props.success(response);                
            }
            if(emit[props.method]) {
                emit[props.method]();
            }
            if(props.clear) {
                formClear();
            }            
        },
        onError: response => {            
            data.errors = response;                 
        }
    });
}

defineComponent('QuillEditor', QuillEditor);
</script>

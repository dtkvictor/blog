<template>        
    <section class="w-full flex justify-center">
        <div class="w-full p-5 bg-white rounded">            
            <slot name="header"></slot>                        

            <div>
                <InputLabel for="name" value="Nome"/>
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full border-gray-300"
                    autofocus                            
                />
                <InputError class="mt-2" :message="data.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full border-gray-300"
                    autofocus                            
                />                    
                <InputError class="mt-2" :message="data.errors.description" />
            </div>                

            <div class="mt-4">
                <InputLabel for="email" value="Administrador"/>        
                <select class="rounded-md shadow-sm border-gray-300 w-full" v-model="form.admin">
                    <option value="1">Sim</option>                    
                    <option value="0">Não</option>
                </select>
                <InputError class="mt-2" :message="data.errors.admin"/>
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
import Checkbox from '@/Components/Checkbox.vue';

import { useForm, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

import '@vueup/vue-quill/dist/vue-quill.snow.css';

const data = reactive({    
    errors: {},
})

const props = defineProps([
    'user',
    'routeName',        
    'success',
    'fails',
]);

const form = useForm({
    name: props.user?.name ?? '',    
    email: props.user?.email ?? '',
    admin: props.user?.admin ?? false
});

const submit = () => {    
    router.visit(props.routeName, {
        method: 'put',
        data: form,
        onSuccess: response => {
            if(props.success) {                
                props.success(response);                
            }          
        },
        onError: response => {            
            data.errors = response
            if(props.fails) {                
                props.fails(response);
            }
        }
    });    
}
</script>

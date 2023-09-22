<template>
    <Head title="Post Create" />
    <DefaultLayout>    
        <section class="w-full flex justify-center">
            <div class="w-full md:w-3/5 p-5 bg-white rounded">
                <div class="w-full flex justify-between">
                    <h1 class="text-3xl mb-3 font-light">Nova postagem</h1>
                    <Link :href="route('post.index')">
                        <span class="material-icons" translate="no">home</span>
                    </Link>
                </div>
                <div v-if="fails" class="mb-4 font-medium text-sm text-red-600">
                    {{ fails }}
                </div>

                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <InputLabel value="Thumb" />
                        <InputFile                             
                            name="thumb"        
                            default="/storage/uploadFile.png"                    
                            imgClass="w-60 h-60"                            
                            @binaryFile="form.thumb = $event"
                        />
                        <InputError class="mt-2" :message="form.errors.thumb" />
                    </div>

                    <div>
                        <InputLabel for="title" value="Título" />
                        <TextInput
                            id="titulo"
                            v-model="form.title"
                            type="text"
                            class="mt-1 block w-full"                            
                            autofocus                            
                        />
                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>


                    <div class="mt-4">
                        <InputLabel for="content" value="Contéudo" />
                        <textarea name="content" class="w-full rounded" v-model="form.content" rows="5"></textarea>
                        <InputError class="mt-2" :message="form.errors.content" />
                    </div>                    

                    <div class="flex items-center justify-end mt-4">                        
                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Postar
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </section>
    </DefaultLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputFile from '@/Components/Form/InputFile.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
    fails: String
});

const form = useForm({
    title: '',
    thumb: '',
    content: '',
});

const submit = () => {
    form.transform(data => ({
        ...data,        
    })).post(route('post.store'), {
        onFinish: console.log("Eu só queria ter um pau do tamanho de um pe de mesa"),
    });
};

</script>

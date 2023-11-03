<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputFile from '@/Components/Form/InputFile.vue';
import iziToast from 'izitoast';

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,    
    picture: null,
});

const updateProfileInformation = () => {
    form.post(route('profile.update'), {        
        preserveScroll: true,
        onSuccess: () => {
            iziToast.success({
                'title': 'Sucesso!',
                'message': 'Perfil atualizado com sucesso.'
            })
        }        
    });
};
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title>
            Informações do perfil
        </template>

        <template #description>
            <!--Update your account's profile information and email address.-->
            Atualize as informações do seu perfil
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4">                
                <InputLabel for="picture" value="Foto de perfil"/>
                <InputFile 
                    name="picture"
                    accept="image/*"
                    :default="user.picture"
                    imgClass="rounded w-[100px] h-[100px]"
                    @binaryFile= "form.picture = $event"                    
                />
                <InputError class="mt-2" :message="form.errors.picture" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Nome" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="name"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError :message="form.errors.email" class="mt-2" />                
            </div>
        </template>

        <template #actions>            
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Atualizar
            </PrimaryButton>
        </template>
    </FormSection>
</template>

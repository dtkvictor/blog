<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { reactive, computed } from 'vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    fails: String
});

const data = reactive({
    profilePicture: null
});

const form = useForm({
    picture: '',
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const loadFile = ($event) => {
    let file = $event.target.files[0];    
    if(!file) return;        
    let fileReader = new FileReader();
    fileReader.onload = (event) => {        
        data.profilePicture = event.target.result;                
    };
    form.picture = file;
    fileReader.readAsDataURL(file);        
}

const getProfilePicture = computed(() => {
    return data.profilePicture ?? 'assets/image/profile.jpg';
})

</script>

<template>
    <Head title="Register" />

    <AuthenticationCard class="pb-5">
        <div class="w-full flex justify-between">
            <h1 class="text-3xl mb-3 font-light">Registrar</h1>     
            <div class="flex justify-center items-center">
                <Link :href="route('site.index')" class="material-icons" translate="no">
                    home
                </Link>       
            </div>
        </div>
        <div v-if="fails" class="mb-4 font-medium text-sm text-red-600">
            {{ fails }}
        </div>

        <form @submit.prevent="submit">

            <div class="mb-3">
                <InputLabel for="picture" value="Foto de perfil" />
                <div class="w-full flex justify-center">                                    
                    <label for="picture" class="flex flex-wrap justify-center items-center">                                                            
                        <img :src="getProfilePicture" alt="picture" class="w-20 h-20 rounded cursor-pointer shadow">                    
                    </label>
                    <input type="file" name="picture" id="picture" class="hidden" @change="loadFile($event)" accept="image/*">
                </div>
                <InputError class="mt-2" :message="form.errors.picture" />
            </div>
            <div>
                <InputLabel for="name" value="Nome" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Senha" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar senha" />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Privacy Policy</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Log In
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>    
</template>

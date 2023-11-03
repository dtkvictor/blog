<script setup>
    import { Head } from '@inertiajs/vue3';
    import DefaultLayout from '@/Layouts/DefaultLayout.vue';
    import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';    
    import SectionBorder from '@/Components/SectionBorder.vue';    
    import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
    import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <DefaultLayout>
        <Head title="Perfil"/>    
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <UpdateProfileInformationForm :user="$page.props.auth" class="md:mb-[-.5rem]"/>                    
                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canUpdatePassword">
                    <UpdatePasswordForm class="mt-5 md:my-[-.5rem]" />
                    <SectionBorder />
                </div>                                

                <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">                    
                    <DeleteUserForm class="mt-5 md:mt-0 md:mt-[-.5rem]" />                    
                </template>
            </div>
        </div>
    </DefaultLayout>
</template>

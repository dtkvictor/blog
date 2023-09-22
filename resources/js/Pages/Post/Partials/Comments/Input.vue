<template>
    <div class="rounded w-full p-5 bg-gray-200" :id="id">                        
        <div class="flex justify-between gap-3">
            <textarea class="w-full rounded" v-model.lazy="text" rows="1" @change="$emit('text', text)"></textarea>
            <PrimaryButton @click="execActionClearInput">{{ btnName }}</PrimaryButton>
        </div>                        
    </div>
</template>
<script>
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    export default {        
        components: { PrimaryButton },
        props: ['id', 'action', 'btnName', 'default'],
        mounted() {
            this.text = this.default;
        },
        data: () => ({
            text: ''
        }),
        methods: {
            execActionClearInput() {
                this.action()
                this.text = ''
            }
        }
    }
</script>
<template>                                   
    <label :for="name" class="flex flex-wrap justify-center items-center">
        <img :src="getImage" alt="picture" :class="['cursor-pointer shadow flex justify-center items-center', getImgCssClass]">
    </label>
    <input type="file" :name="name" :id="name" class="hidden" @change="loadFile($event)" :accept="accept">                
</template>

<script>
export default {
    props: ['name', 'accept', 'default', 'imgClass'],
    emits: ['binaryFile'],
    data: () => ({
        url: ''
    }),

    methods: {
        loadFile($event) {
            let file = $event.target.files[0];    
            if(!file) return;        
            let fileReader = new FileReader();
            fileReader.onload = (event) => {                        
                this.url = event.target.result;
            };            
            this.$emit('binaryFile', file);
            fileReader.readAsDataURL(file);
        }
    },
    
    computed: {
        getImage() {                        
            if(this.url === null || this.url === '') return this.default;
            return this.url;
        },
        getImgCssClass() {
            return this.imgClass ?? 'w-20 h-20 rounded-full'
        }
    }
}
</script>
<template>                                   
    <label :for="name" class="flex flex-wrap justify-center items-center">
        <img :src="getImage" alt="picture" :class="['rounded cursor-pointer shadow', imgClass]">                    
    </label>
    <input type="file" :name="name" :id="name" class="hidden" @change="loadFile($event)" :accept="accept">                
</template>

<script>
export default {
    props: ['name', 'accept', 'default', 'imgClass'],
    
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
            return this.default ?? this.url;
        }
    }
}
</script>
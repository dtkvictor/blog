<template>
    <div class="w-full flex mb-3 gap-3 duration-1000" v-for="card in range()" :key="card">
        <span class="min-w-[50px] min-h-[50px] rounded-full loading"></span>
        <div class="rounded w-full flex justify-between p-1 ps-3 pe-3 loading"></div>                                            
    </div>
</template>
<script>
    export default {
        props: ['amount'],
        methods: {
            range(){
                let array = [];
                if(this.amount) {
                    for(let i = 0; i < this.amount; i++) {
                        array.push(i);
                    } 
                }                
                return array;
            }
        }
    }
</script>
<style scoped>
    .loading {
        background: linear-gradient(to bottom, #f3f3f3, #e5e7eb, #f3f3f3);
        animation: linear 1s load infinite;
    }

    @keyframes load {
        from {
            background-position-y: 0px;
        }
        to {
            background-position-y: 50px;
        }
    }
</style>
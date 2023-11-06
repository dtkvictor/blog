<template>
    <div class="w-full flex justify-center gap-3 flex-wrap">        
        <Link 
            v-for="link, index in getLinks" 
            :key="index" 
            v-html="link.label" 
            :href="link.url ?? currentURL"
            :class="[
                'w-[40px] h-[40px] flex justify-center items-center p-2',
                'rounded shadow hover:bg-gray-500 hover:text-white active:scale-75',
                { 'bg-white': !link.active },
                { 'bg-neutral-900 text-white': link.active }
            ]"            
        />
    </div>
</template>
<script>
    import { Link } from '@inertiajs/vue3';    
    export default {
        components: { Link },
        props: ['links'],
        computed: {
            getLinks() {                                
                let links = this.links;
                links.shift(); links.pop();
                if(links.length <= 1) return [];                
                return links;
            },
            currentURL() {
                return window.location.href;
            }
        },        
    }
</script>
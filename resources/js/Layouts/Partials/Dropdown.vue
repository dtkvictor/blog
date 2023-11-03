<template>
    <Dropdown>
        <template v-slot:trigger>
            <div class="flex justify-center items-center gap-4 cursor-pointer active:scale-75">                        
                <button class="flex">
                    <span class="material-icons-round size-icons" translate="no" style="font-size: 50px">
                        menu
                    </span>
                </button>
            </div>            
        </template>
        <template v-slot:content>
            <NavLinks></NavLinks>
        </template>
    </Dropdown>                  
</template>

<script setup>    
    import Dropdown from '@/Components/Dropdown.vue';
    import NavLinks from '@/Layouts/Partials/NavLinks.vue'    
</script>
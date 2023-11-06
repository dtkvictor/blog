import { defineStore } from "pinia";
import axios from "axios";

const fetchCategories = async () => {
    const response = await axios.get(route('api.category'));    
    const category = await response.data.data;
    return category;
}

const fetchAuthories = async () => {
    const response = await axios.get(route('api.author'));    
    const author = await response.data.data;
    return author;
}

export default defineStore('store', {
    state: () => ({        
        categories: [],
        authories: [],
    }),
    actions: {
        async fetchData() {
            if(this.categories.length < 1) this.categories = await fetchCategories();
            if(this.authories.length < 1) this.authories = await fetchAuthories();
        },
        async refreshCategory() {
            this.categories = await fetchCategories();
        },
        updateCategory(update) {                        
            const index = this.categories.findIndex(category => category.id == update.id);            
            if(this.categories[index]) {
                this.categories[index] = update;
            }
        }
    },
    getters: {
        firstCategory() {
            if(this.categories[0]){
                return this.categories[0];
            }                        
        }
    }   
});
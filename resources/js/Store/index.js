import { defineStore } from "pinia";
import axios from "axios";

const categories = ( await axios.get(route('api.category')) ).data.data;
const authories = ( await axios.get(route('api.author')) ).data.data;

export default defineStore('store', {
    state: () => ({
        categories: categories,
        authories: authories,
    }),
    actions: {
        addCategory(category) {
            this.categories.push(category)
        },
        removeCategory(remove) {
            this.categories = this.categories.filter(
                category => category.id != remove.id
            )
        }
    },
    getters: {
        firstCategory() {
            return this.categories[0];
        }
    }   
});
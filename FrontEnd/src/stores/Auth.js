import { defineStore } from "pinia";
import { ref } from "vue";
import { Axios } from "axios";

export const useAuthStore = defineStore("auth", () => {
    const user = ref(null);

    const loaduser =  () => {
        const savedUser = localStorage.getItem("user");
        if(savedUser){
            user.value = JSON.parse(savedUser)
        }
    }

    // function to set user data on login 

    const setUser = (userData) => {
        user.value = userData;
        localStorage.setItem("user", JSON.stringify(userData));
    }

    //function to clear the user data in login 
    const logout = () => {
        user.value = null;
        localStorage.removeItem("user");
        localStorage.removeItem("token");
    }

    return { user, loaduser, setUser, logout }    
})
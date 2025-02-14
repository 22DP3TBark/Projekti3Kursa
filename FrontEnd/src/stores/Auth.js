import { defineStore } from "pinia";
import { ref } from "vue";
import { Axios } from "axios";
import router from "@/router";

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
        user.value = null;
        router.push("/login");
    }

    return { user, loaduser, setUser, logout }    
})
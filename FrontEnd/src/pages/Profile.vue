<script setup>
import { useAuth } from "@/stores/useAuth";

const { user } = useAuth();


</script>

<template>

    <div class="profile-container">
        <h1>Profile</h1>
        <div class="profile-values">
            <p>Name: {{ user.name }}</p>
            <p>LastName: {{ user.lastname }}</p>
            <p>UserName: {{ user.username }}</p>
            <p>Email:{{ user.email }} </p>
            <p>Phone: {{ user.phone }} </p>
            

        </div>
    </div>
</template>

<style scoped>
   .profile-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100vw;
        min-height: 100vh;
    }

    h1 {
        text-align: center;
        margin-top: 50px;
        margin-bottom: 20px; /* Adjusted margin to be closer to the profile values */
    }

    .profile-values {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border: 1px solid black;
        padding: 40px;
        border-radius: 10px;
    }

    .profile-values p {
        font-size: 20px; /* Adjust the font size as needed */
    }


</style>
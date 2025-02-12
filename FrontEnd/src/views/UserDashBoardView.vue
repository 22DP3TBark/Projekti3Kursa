<script setup>
import {useAuthStore} from '@/stores/Auth';
import { computed, onMounted } from "vue";

const authStore = useAuthStore();



const user = computed(() => authStore.user);

</script>

<template>
    <div class="userDash">
        <div class="userinfo-container">
            <p>Welcom</p>
            <span>name: {{ user.name }}</span>
            <span>email: {{ user.email }}</span>
        </div>
    </div>
</template>

<style scoped>
@import '../assets/UDB.css';
</style>
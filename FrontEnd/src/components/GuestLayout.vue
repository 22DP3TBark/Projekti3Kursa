<script setup>
import { useRoute } from 'vue-router';
import Navbar from '@/components/Navbar.vue'

const route = useRoute()


</script>

<template>
    <Navbar />
        <router-view />

</template>

<style>

</style>
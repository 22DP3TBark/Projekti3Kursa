<script setup>
import { RouterLink } from 'vue-router';


</script>

<template>
    <header :class="{'scrolled-nav': scrolledPosition}">
        <nav>
            <div class="branding">

            </div>

            <ul v-show="!mobile" class="Navigation">
                <li><RouterLink class="link" :to="{name: ''}">Home</RouterLink></li>
                <li><RouterLink class="link" to="">about</RouterLink></li>
                <li><RouterLink class="link" to="">Contact</RouterLink></li>
                <li><RouterLink class="link" to="">Login</RouterLink></li>
                <li><RouterLink class="link" to="">Register</RouterLink></li>
            </ul>

            <div class="icon">
                    <i class="" ></i>
                </div>
        </nav>
    </header>
</template>

<style scoped>
@import '@/assets/navbar.css';
</style>
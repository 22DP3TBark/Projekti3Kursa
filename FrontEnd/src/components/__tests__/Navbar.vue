<script setup>
import { RouterLink } from 'vue-router';


</script>

<template>
    <header :class="{'scrolled-nav': scrolledPosition}">
        <nav>
            <div class="branding">

            </div>

            <ul v-show="!mobile" class="Navigation">
                <!--<li><RouterLink class="link" :to="{name: ''}">Home</RouterLink></li>-->
                <!--<li><RouterLink class="link" to="">about</RouterLink></li>-->
                <!--<li><RouterLink class="link" to="">Contact</RouterLink></li>-->
                <li><RouterLink class="link" to="/login">Login</RouterLink></li>
                <li><RouterLink class="link" to="/register">Register</RouterLink></li>
            </ul>

            <div class="icon">
                    <i class=""></i>
                </div>
        </nav>
    </header>
</template>

<style scoped>
@import '@/assets/Navbar.css';
</style>
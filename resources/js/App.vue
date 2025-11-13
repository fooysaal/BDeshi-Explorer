<template>
  <router-view />
</template>

<script setup>
import { onMounted } from 'vue';
import AOS from 'aos';
import 'aos/dist/aos.css';

onMounted(() => {
  // Initialize AOS animations
  AOS.init({
    duration: 800,
    once: true,
  });
});
</script>

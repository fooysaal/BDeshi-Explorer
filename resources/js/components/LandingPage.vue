<template>
  <div class="min-h-screen bg-white">
    <NavigationMenu />
    <HeroSection />
    <AboutSection />
    <ToursSection />
    <EventsSection />
    <TestimonialsSection />
    <CTASection />
    <FooterSection />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import NavigationMenu from './NavigationMenu.vue';
import HeroSection from './HeroSection.vue';
import AboutSection from './AboutSection.vue';
import ToursSection from './ToursSection.vue';
import EventsSection from './EventsSection.vue';
import TestimonialsSection from './TestimonialsSection.vue';
import CTASection from './CTASection.vue';
import FooterSection from './FooterSection.vue';

onMounted(() => {
  console.log('Bdeshi Explorer Landing Page loaded');
});
</script>

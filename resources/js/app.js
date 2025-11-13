import './bootstrap';
import { createApp } from 'vue';
import LandingPage from './components/LandingPage.vue';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Initialize AOS (Animate On Scroll)
AOS.init({
    duration: 800,
    offset: 100,
    once: true,
    easing: 'ease-in-out',
});

// Create Vue App
const app = createApp(LandingPage);
app.mount('#app');

<template>
  <nav
    :class="[
      'fixed top-0 left-0 right-0 z-50 transition-all duration-300',
      isScrolled ? 'bg-white shadow-lg' : 'bg-transparent'
    ]"
  >
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <div class="flex-shrink-0">
          <a href="#home" class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-gradient-emerald rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <span :class="['text-xl font-bold', isScrolled ? 'text-gray-900' : 'text-white']">
              Bdeshi Explorer
            </span>
          </a>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-8">
          <a
            v-for="item in menuItems"
            :key="item.href"
            :href="item.href"
            :class="[
              'text-sm font-medium transition-colors duration-200 hover:text-emerald-500',
              isScrolled ? 'text-gray-700' : 'text-white',
              activeSection === item.section && 'text-emerald-500 font-semibold'
            ]"
            @click.prevent="scrollToSection(item.href)"
          >
            {{ item.label }}
          </a>
        </div>

        <!-- CTA Buttons -->
        <div class="hidden md:flex items-center space-x-4">
          <a
            href="#login"
            :class="[
              'text-sm font-medium transition-colors duration-200',
              isScrolled ? 'text-gray-700 hover:text-emerald-500' : 'text-white hover:text-emerald-300'
            ]"
          >
            Login
          </a>
          <a
            href="#register"
            class="bg-gradient-emerald text-white px-6 py-2 rounded-full text-sm font-semibold hover:shadow-lg transition-all duration-200"
          >
            Register
          </a>
        </div>

        <!-- Mobile Menu Button -->
        <button
          @click="mobileMenuOpen = !mobileMenuOpen"
          :class="['md:hidden p-2 rounded-lg transition-colors', isScrolled ? 'text-gray-700' : 'text-white']"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Mobile Menu -->
      <transition name="slide-fade">
        <div v-if="mobileMenuOpen" class="md:hidden py-4 bg-white shadow-lg rounded-b-lg">
          <a
            v-for="item in menuItems"
            :key="item.href"
            :href="item.href"
            class="block px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors"
            @click="handleMobileClick(item.href)"
          >
            {{ item.label }}
          </a>
          <div class="px-4 py-3 border-t border-gray-200 mt-2 space-y-2">
            <a href="#login" class="block text-gray-700 hover:text-emerald-600">Login</a>
            <a href="#register" class="block bg-gradient-emerald text-white px-6 py-2 rounded-full text-center font-semibold">
              Register
            </a>
          </div>
        </div>
      </transition>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);
const activeSection = ref('home');

const menuItems = [
  { label: 'Home', href: '#home', section: 'home' },
  { label: 'About', href: '#about', section: 'about' },
  { label: 'Tours & Offers', href: '#tours', section: 'tours' },
  { label: 'Events', href: '#events', section: 'events' },
  { label: 'Explore', href: '#testimonials', section: 'testimonials' },
  { label: 'Contact', href: '#contact', section: 'contact' },
];

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50;

  // Update active section based on scroll position
  const sections = ['home', 'about', 'tours', 'events', 'testimonials', 'contact'];
  for (const section of sections) {
    const element = document.getElementById(section);
    if (element) {
      const rect = element.getBoundingClientRect();
      if (rect.top <= 100 && rect.bottom >= 100) {
        activeSection.value = section;
        break;
      }
    }
  }
};

const scrollToSection = (href) => {
  const targetId = href.substring(1);
  const element = document.getElementById(targetId);
  if (element) {
    const offset = 80;
    const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
    const offsetPosition = elementPosition - offset;

    window.scrollTo({
      top: offsetPosition,
      behavior: 'smooth'
    });
  }
};

const handleMobileClick = (href) => {
  scrollToSection(href);
  mobileMenuOpen.value = false;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
  handleScroll();
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(-10px);
  opacity: 0;
}
</style>

<template>
  <nav
    :class="{ 'bg-white shadow-lg': isScrolled, 'bg-transparent': !isScrolled }"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
  >
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between h-20">
        <!-- Logo -->
        <router-link
          to="/"
          class="text-2xl font-bold flex items-center gap-2"
          :class="isScrolled ? 'text-emerald-600' : 'text-white'"
        >
          <span class="text-3xl">🏔️</span>
          Bdeshi Explorer
        </router-link>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center gap-8">
          <a
            v-for="link in navLinks"
            :key="link.name"
            :href="link.path"
            @click.prevent="scrollToSection(link.path)"
            class="font-medium transition-colors hover:text-emerald-500"
            :class="isScrolled ? 'text-gray-700' : 'text-white'"
          >
            {{ link.name }}
          </a>

          <!-- Auth Links -->
          <div v-if="!isAuthenticated" class="flex items-center gap-3">
            <router-link
              to="/login"
              class="font-medium transition-colors hover:text-emerald-500"
              :class="isScrolled ? 'text-gray-700' : 'text-white'"
            >
              Login
            </router-link>
            <router-link
              to="/register"
              class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-full font-medium transition"
            >
              Sign Up
            </router-link>
          </div>

          <!-- User Menu -->
          <div v-else class="relative">
            <button
              @click="showUserMenu = !showUserMenu"
              class="flex items-center gap-2 font-medium transition-colors hover:text-emerald-500"
              :class="isScrolled ? 'text-gray-700' : 'text-white'"
            >
              <span>👤</span>
              {{ user?.name }}
              <span class="text-sm">▼</span>
            </button>

            <!-- Dropdown -->
            <div
              v-if="showUserMenu"
              class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2"
            >
              <router-link
                to="/dashboard"
                class="block px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"
                @click="showUserMenu = false"
              >
                Dashboard
              </router-link>
              <router-link
                to="/my-bookings"
                class="block px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"
                @click="showUserMenu = false"
              >
                My Bookings
              </router-link>
              <button
                @click="handleLogout"
                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50"
              >
                Logout
              </button>
            </div>
          </div>
        </div>

        <!-- Mobile Menu Button -->
        <button
          @click="isMobileMenuOpen = !isMobileMenuOpen"
          class="md:hidden"
          :class="isScrolled ? 'text-gray-700' : 'text-white'"
        >
          <span class="text-2xl">{{ isMobileMenuOpen ? '✕' : '☰' }}</span>
        </button>
      </div>

      <!-- Mobile Menu -->
      <div
        v-if="isMobileMenuOpen"
        class="md:hidden bg-white shadow-lg rounded-lg mt-2 mb-4 p-4"
      >
        <a
          v-for="link in navLinks"
          :key="link.name"
          :href="link.path"
          @click="handleMobileClick(link.path)"
          class="block py-3 text-gray-700 hover:text-emerald-600 font-medium border-b"
        >
          {{ link.name }}
        </a>

        <div v-if="!isAuthenticated" class="mt-4 space-y-2">
          <router-link
            to="/login"
            class="block py-2 text-center text-gray-700 hover:text-emerald-600 font-medium"
            @click="isMobileMenuOpen = false"
          >
            Login
          </router-link>
          <router-link
            to="/register"
            class="block py-2 text-center bg-emerald-600 text-white rounded-lg font-medium"
            @click="isMobileMenuOpen = false"
          >
            Sign Up
          </router-link>
        </div>

        <div v-else class="mt-4 space-y-2">
          <router-link
            to="/dashboard"
            class="block py-2 text-gray-700 hover:text-emerald-600 font-medium"
            @click="isMobileMenuOpen = false"
          >
            Dashboard
          </router-link>
          <router-link
            to="/my-bookings"
            class="block py-2 text-gray-700 hover:text-emerald-600 font-medium"
            @click="isMobileMenuOpen = false"
          >
            My Bookings
          </router-link>
          <button
            @click="handleLogout"
            class="block w-full py-2 text-left text-red-600 hover:text-red-700 font-medium"
          >
            Logout
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);
const showUserMenu = ref(false);

const isAuthenticated = computed(() => authStore.isAuthenticated);
const user = computed(() => authStore.user);

const navLinks = [
  { name: 'Home', path: '#home' },
  { name: 'About', path: '#about' },
  { name: 'Tours', path: '#tours' },
  { name: 'Events', path: '#events' },
  { name: 'Testimonials', path: '#testimonials' },
];

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50;
};

const scrollToSection = (path) => {
  if (router.currentRoute.value.path !== '/') {
    router.push('/');
    setTimeout(() => {
      const element = document.querySelector(path);
      element?.scrollIntoView({ behavior: 'smooth' });
    }, 100);
  } else {
    const element = document.querySelector(path);
    element?.scrollIntoView({ behavior: 'smooth' });
  }
};

const handleMobileClick = (path) => {
  isMobileMenuOpen.value = false;
  scrollToSection(path);
};

const handleLogout = async () => {
  await authStore.logout();
  showUserMenu.value = false;
  isMobileMenuOpen.value = false;
  router.push('/');
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

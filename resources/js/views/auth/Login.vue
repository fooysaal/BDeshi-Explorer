<template>
  <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-sky-50 flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
      <!-- Logo/Header -->
      <div class="text-center mb-8">
        <router-link to="/" class="inline-flex items-center gap-2 text-3xl font-bold text-emerald-600 mb-2">
          🏔️ Bdeshi Explorer
        </router-link>
        <p class="text-gray-600">Welcome back! Login to your account</p>
      </div>

      <!-- Login Form -->
      <div class="bg-white rounded-2xl shadow-xl p-8">
        <form @submit.prevent="handleLogin">
          <!-- Email -->
          <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Email Address</label>
            <input
              v-model="form.email"
              type="email"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
              placeholder="your@email.com"
            />
            <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email[0] }}</p>
          </div>

          <!-- Password -->
          <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Password</label>
            <input
              v-model="form.password"
              type="password"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
              placeholder="••••••••"
            />
            <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password[0] }}</p>
          </div>

          <!-- Error Message -->
          <div v-if="errorMessage" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            {{ errorMessage }}
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="loading"
            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 disabled:opacity-50"
          >
            <span v-if="!loading">Login</span>
            <span v-else>Logging in...</span>
          </button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 text-center">
          <p class="text-gray-600">
            Don't have an account?
            <router-link to="/register" class="text-emerald-600 hover:text-emerald-700 font-semibold">
              Register here
            </router-link>
          </p>
        </div>

        <!-- Demo Credentials -->
        <div class="mt-6 p-4 bg-sky-50 rounded-lg">
          <p class="text-sm font-semibold text-gray-700 mb-2">Demo Accounts:</p>
          <div class="text-xs text-gray-600 space-y-1">
            <p><strong>Admin:</strong> admin@bdeshi-explorer.com / password</p>
            <p><strong>Explorer:</strong> explorer@example.com / password</p>
          </div>
        </div>
      </div>

      <!-- Back to Home -->
      <div class="text-center mt-6">
        <router-link to="/" class="text-gray-600 hover:text-emerald-600 transition">
          ← Back to Home
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '../../stores/auth';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();

const form = ref({
  email: '',
  password: ''
});

const errors = ref({});
const errorMessage = ref('');
const loading = ref(false);

const handleLogin = async () => {
  loading.value = true;
  errors.value = {};
  errorMessage.value = '';

  try {
    await authStore.login(form.value);

    // Redirect to intended page or dashboard
    const redirectTo = route.query.redirect || '/dashboard';
    router.push(redirectTo);
  } catch (error) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors;
    } else {
      errorMessage.value = error.response?.data?.message || 'Login failed. Please try again.';
    }
  } finally {
    loading.value = false;
  }
};
</script>

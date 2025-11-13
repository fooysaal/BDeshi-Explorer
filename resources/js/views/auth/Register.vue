<template>
  <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-sky-50 flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
      <!-- Logo/Header -->
      <div class="text-center mb-8">
        <router-link to="/" class="inline-flex items-center gap-2 text-3xl font-bold text-emerald-600 mb-2">
          🏔️ Bdeshi Explorer
        </router-link>
        <p class="text-gray-600">Create your account and start exploring!</p>
      </div>

      <!-- Register Form -->
      <div class="bg-white rounded-2xl shadow-xl p-8">
        <form @submit.prevent="handleRegister">
          <!-- Name -->
          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
            <input
              v-model="form.name"
              type="text"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
              placeholder="John Doe"
            />
            <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name[0] }}</p>
          </div>

          <!-- Email -->
          <div class="mb-4">
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

          <!-- Phone -->
          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Phone Number (Optional)</label>
            <input
              v-model="form.phone"
              type="tel"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
              placeholder="+880 1700-000000"
            />
            <p v-if="errors.phone" class="text-red-500 text-sm mt-1">{{ errors.phone[0] }}</p>
          </div>

          <!-- Address -->
          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Address (Optional)</label>
            <input
              v-model="form.address"
              type="text"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
              placeholder="Dhaka, Bangladesh"
            />
            <p v-if="errors.address" class="text-red-500 text-sm mt-1">{{ errors.address[0] }}</p>
          </div>

          <!-- Password -->
          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Password</label>
            <input
              v-model="form.password"
              type="password"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
              placeholder="••••••••"
            />
            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
            <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password[0] }}</p>
          </div>

          <!-- Confirm Password -->
          <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
            <input
              v-model="form.password_confirmation"
              type="password"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
              placeholder="••••••••"
            />
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
            <span v-if="!loading">Create Account</span>
            <span v-else>Creating Account...</span>
          </button>
        </form>

        <!-- Login Link -->
        <div class="mt-6 text-center">
          <p class="text-gray-600">
            Already have an account?
            <router-link to="/login" class="text-emerald-600 hover:text-emerald-700 font-semibold">
              Login here
            </router-link>
          </p>
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
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const form = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
  password: '',
  password_confirmation: ''
});

const errors = ref({});
const errorMessage = ref('');
const loading = ref(false);

const handleRegister = async () => {
  loading.value = true;
  errors.value = {};
  errorMessage.value = '';

  try {
    await authStore.register(form.value);
    router.push('/dashboard');
  } catch (error) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors;
    } else {
      errorMessage.value = error.response?.data?.message || 'Registration failed. Please try again.';
    }
  } finally {
    loading.value = false;
  }
};
</script>

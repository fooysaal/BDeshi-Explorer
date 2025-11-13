<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Fixed background for navigation visibility -->
    <div class="fixed top-0 left-0 right-0 h-20 bg-white shadow-md z-40"></div>
    <NavigationMenu />

    <div class="container mx-auto px-4 py-24">
      <!-- Welcome Header -->
      <div class="bg-gradient-to-r from-emerald-600 to-sky-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
        <h1 class="text-4xl font-bold mb-2">Welcome, {{ user?.name }}!</h1>
        <p class="text-emerald-100">Manage your bookings and explore new adventures</p>
      </div>

      <!-- Quick Stats -->
      <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-500 text-sm">Total Bookings</p>
              <p class="text-3xl font-bold text-gray-900">{{ stats.total }}</p>
            </div>
            <div class="text-4xl">📋</div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-500 text-sm">Pending</p>
              <p class="text-3xl font-bold text-yellow-600">{{ stats.pending }}</p>
            </div>
            <div class="text-4xl">⏳</div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-500 text-sm">Approved</p>
              <p class="text-3xl font-bold text-green-600">{{ stats.approved }}</p>
            </div>
            <div class="text-4xl">✅</div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-500 text-sm">Completed</p>
              <p class="text-3xl font-bold text-purple-600">{{ stats.completed }}</p>
            </div>
            <div class="text-4xl">🎉</div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="grid md:grid-cols-3 gap-6 mb-8">
        <router-link
          to="/#tours"
          class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition group"
        >
          <div class="text-5xl mb-4 group-hover:scale-110 transition">🏔️</div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Explore Tours</h3>
          <p class="text-gray-600">Discover new adventures and destinations</p>
        </router-link>

        <router-link
          to="/my-bookings"
          class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition group"
        >
          <div class="text-5xl mb-4 group-hover:scale-110 transition">📅</div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">My Bookings</h3>
          <p class="text-gray-600">View and manage your reservations</p>
        </router-link>

        <button
          @click="showProfileModal = true"
          class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition group text-left"
        >
          <div class="text-5xl mb-4 group-hover:scale-110 transition">👤</div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Update Profile</h3>
          <p class="text-gray-600">Edit your account information</p>
        </button>
      </div>

      <!-- Recent Bookings -->
      <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Bookings</h2>

        <div v-if="loading" class="flex justify-center py-8">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600"></div>
        </div>

        <div v-else-if="recentBookings.length > 0" class="space-y-4">
          <div
            v-for="booking in recentBookings"
            :key="booking.id"
            class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition"
          >
            <div class="flex items-center gap-4">
              <img
                :src="booking.tour?.image"
                :alt="booking.tour?.name"
                class="w-16 h-16 object-cover rounded-lg"
              />
              <div>
                <h4 class="font-semibold text-gray-900">{{ booking.tour?.name }}</h4>
                <p class="text-sm text-gray-600">{{ booking.booking_number }}</p>
              </div>
            </div>
            <div class="text-right">
              <span
                class="inline-block px-3 py-1 rounded-full text-sm font-semibold mb-1"
                :class="getStatusClass(booking.status)"
              >
                {{ formatStatus(booking.status) }}
              </span>
              <p class="text-sm text-gray-600">৳{{ booking.total_price.toLocaleString() }}</p>
            </div>
          </div>

          <router-link
            to="/my-bookings"
            class="block text-center text-emerald-600 hover:text-emerald-700 font-semibold mt-4"
          >
            View All Bookings →
          </router-link>
        </div>

        <div v-else class="text-center py-8">
          <p class="text-gray-600">No bookings yet. Start exploring!</p>
        </div>
      </div>
    </div>

    <FooterSection />

    <!-- Profile Update Modal -->
    <div v-if="showProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-2xl p-8 max-w-md w-full max-h-screen overflow-y-auto">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Update Profile</h3>

        <form @submit.prevent="updateProfile">
          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Name</label>
            <input
              v-model="profileForm.name"
              type="text"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
            />
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Phone</label>
            <input
              v-model="profileForm.phone"
              type="tel"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
            />
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Address</label>
            <input
              v-model="profileForm.address"
              type="text"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
            />
          </div>

          <div class="flex gap-3">
            <button
              type="submit"
              :disabled="updating"
              class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-lg transition disabled:opacity-50"
            >
              {{ updating ? 'Saving...' : 'Save Changes' }}
            </button>
            <button
              type="button"
              @click="showProfileModal = false"
              class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition"
            >
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useAuthStore } from '../../stores/auth';
import axios from 'axios';
import NavigationMenu from '../../components/NavigationMenu.vue';
import FooterSection from '../../components/FooterSection.vue';

const authStore = useAuthStore();
const user = computed(() => authStore.user);

const bookings = ref([]);
const loading = ref(true);
const showProfileModal = ref(false);
const updating = ref(false);

const profileForm = ref({
  name: '',
  phone: '',
  address: ''
});

const stats = computed(() => {
  return {
    total: bookings.value.length,
    pending: bookings.value.filter(b => b.status === 'pending').length,
    approved: bookings.value.filter(b => b.status === 'approved').length,
    completed: bookings.value.filter(b => b.status === 'completed').length
  };
});

const recentBookings = computed(() => {
  return bookings.value.slice(0, 5);
});

const getStatusClass = (status) => {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-800',
    in_process: 'bg-blue-100 text-blue-800',
    approved: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
    completed: 'bg-purple-100 text-purple-800'
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};

const formatStatus = (status) => {
  return status.replace('_', ' ').toUpperCase();
};

const updateProfile = async () => {
  updating.value = true;

  try {
    await authStore.updateProfile(profileForm.value);
    showProfileModal.value = false;
    alert('Profile updated successfully!');
  } catch (error) {
    alert('Failed to update profile');
  } finally {
    updating.value = false;
  }
};

onMounted(async () => {
  try {
    const response = await axios.get('/api/v1/bookings');
    bookings.value = response.data.data || response.data;

    // Initialize profile form
    profileForm.value.name = user.value?.name || '';
    profileForm.value.phone = user.value?.phone || '';
    profileForm.value.address = user.value?.address || '';
  } catch (error) {
    console.error('Error fetching bookings:', error);
  } finally {
    loading.value = false;
  }
});
</script>

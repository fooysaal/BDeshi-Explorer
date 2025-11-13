<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <NavigationMenu />

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center h-screen">
      <div class="text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-emerald-600 mx-auto"></div>
        <p class="mt-4 text-gray-600">Loading tour details...</p>
      </div>
    </div>

    <!-- Tour Details -->
    <div v-else-if="tour" class="container mx-auto px-4 py-24">
      <!-- Hero Section with Image Gallery -->
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="md:flex">
          <!-- Main Image -->
          <div class="md:w-2/3">
            <img
              :src="currentImage"
              :alt="tour.name"
              class="w-full h-96 object-cover"
            />
            <!-- Gallery Thumbnails -->
            <div class="flex gap-2 p-4 overflow-x-auto">
              <img
                v-for="(img, index) in tour.gallery || tour.images"
                :key="index"
                :src="img"
                @click="currentImage = img"
                class="w-20 h-20 object-cover rounded cursor-pointer hover:opacity-75 transition"
                :class="{ 'ring-2 ring-emerald-600': currentImage === img }"
              />
            </div>
          </div>

          <!-- Tour Info Card -->
          <div class="md:w-1/3 p-8 bg-gradient-to-br from-emerald-50 to-sky-50">
            <div class="mb-4">
              <span class="px-3 py-1 bg-emerald-600 text-white rounded-full text-sm">{{ tour.category }}</span>
              <span v-if="tour.is_featured" class="ml-2 px-3 py-1 bg-yellow-500 text-white rounded-full text-sm">⭐ Featured</span>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ tour.name }}</h1>
            <p class="text-gray-600 mb-4">📍 {{ tour.location }}</p>

            <div class="space-y-3 mb-6">
              <div class="flex items-center justify-between">
                <span class="text-gray-600">Duration</span>
                <span class="font-semibold">{{ tour.duration }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-gray-600">Price per Person</span>
                <span class="text-2xl font-bold text-emerald-600">৳{{ tour.price.toLocaleString() }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-gray-600">Rating</span>
                <span class="font-semibold">⭐ {{ tour.rating }} / 5.0</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-gray-600">Available Slots</span>
                <span class="font-semibold text-emerald-600">{{ tour.available_capacity }} / {{ tour.total_capacity }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-gray-600">Dates</span>
                <span class="font-semibold text-sm">{{ formatDate(tour.start_date) }} - {{ formatDate(tour.end_date) }}</span>
              </div>
            </div>

            <!-- Book Now Button -->
            <button
              v-if="tour.available_capacity > 0 && tour.is_active"
              @click="handleBookNow"
              class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 px-6 rounded-xl transition duration-300 transform hover:scale-105 shadow-lg"
            >
              Book Now
            </button>
            <div v-else class="w-full bg-gray-400 text-white font-bold py-4 px-6 rounded-xl text-center">
              Fully Booked
            </div>
          </div>
        </div>
      </div>

      <!-- Tabs Navigation -->
      <div class="bg-white rounded-t-2xl shadow-lg overflow-hidden">
        <div class="flex border-b">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            class="flex-1 py-4 px-6 font-semibold transition"
            :class="activeTab === tab.id ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
          >
            {{ tab.label }}
          </button>
        </div>

        <!-- Tab Content -->
        <div class="p-8">
          <!-- Description Tab -->
          <div v-if="activeTab === 'description'" class="prose max-w-none">
            <h2 class="text-2xl font-bold mb-4">About This Tour</h2>
            <p class="text-gray-700 leading-relaxed">{{ tour.description }}</p>

            <h3 class="text-xl font-bold mt-6 mb-3">Safety Terms</h3>
            <p class="text-gray-700">{{ tour.safety_terms || 'Follow guide instructions and stay with the group.' }}</p>
          </div>

          <!-- Highlights Tab -->
          <div v-if="activeTab === 'highlights'" class="space-y-4">
            <h2 class="text-2xl font-bold mb-4">Tour Highlights</h2>
            <div class="grid md:grid-cols-2 gap-4">
              <div v-for="(highlight, index) in highlightsList" :key="index" class="flex items-start gap-3">
                <span class="text-emerald-600 text-xl">✓</span>
                <span class="text-gray-700">{{ highlight }}</span>
              </div>
            </div>
          </div>

          <!-- Included/Excluded Tab -->
          <div v-if="activeTab === 'included'">
            <div class="grid md:grid-cols-2 gap-8">
              <div>
                <h2 class="text-2xl font-bold mb-4 text-emerald-600">✓ Included</h2>
                <div class="space-y-2">
                  <div v-for="(item, index) in includedList" :key="index" class="flex items-start gap-2">
                    <span class="text-emerald-600">✓</span>
                    <span class="text-gray-700">{{ item }}</span>
                  </div>
                </div>
              </div>
              <div>
                <h2 class="text-2xl font-bold mb-4 text-red-600">✗ Excluded</h2>
                <div class="space-y-2">
                  <div v-for="(item, index) in excludedList" :key="index" class="flex items-start gap-2">
                    <span class="text-red-600">✗</span>
                    <span class="text-gray-700">{{ item }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Itinerary Tab -->
          <div v-if="activeTab === 'itinerary'">
            <h2 class="text-2xl font-bold mb-4">Tour Itinerary</h2>
            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ tour.itinerary || 'Detailed itinerary will be provided upon booking confirmation.' }}</p>
          </div>

          <!-- Host Info Tab -->
          <div v-if="activeTab === 'host' && tour.host">
            <h2 class="text-2xl font-bold mb-4">Tour Host</h2>
            <div class="bg-gray-50 p-6 rounded-xl">
              <p class="text-lg font-semibold text-gray-900">{{ tour.host.name }}</p>
              <p class="text-gray-600">{{ tour.host.email }}</p>
              <p v-if="tour.host.phone" class="text-gray-600">{{ tour.host.phone }}</p>
              <span class="inline-block mt-2 px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm">
                {{ tour.host.role }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Error State -->
    <div v-else class="flex justify-center items-center h-screen">
      <div class="text-center">
        <p class="text-xl text-gray-600">Tour not found</p>
        <router-link to="/" class="mt-4 inline-block text-emerald-600 hover:text-emerald-700">
          ← Back to Home
        </router-link>
      </div>
    </div>

    <!-- Footer -->
    <FooterSection />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';
import axios from 'axios';
import NavigationMenu from '../../components/NavigationMenu.vue';
import FooterSection from '../../components/FooterSection.vue';

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

const tour = ref(null);
const loading = ref(true);
const currentImage = ref('');
const activeTab = ref('description');

const tabs = [
  { id: 'description', label: 'Description' },
  { id: 'highlights', label: 'Highlights' },
  { id: 'included', label: 'Included/Excluded' },
  { id: 'itinerary', label: 'Itinerary' },
  { id: 'host', label: 'Host Info' }
];

const highlightsList = computed(() => {
  if (!tour.value?.highlights) return [];
  return tour.value.highlights.split(',').map(h => h.trim());
});

const includedList = computed(() => {
  if (!tour.value?.included) return [];
  return tour.value.included.split(',').map(i => i.trim());
});

const excludedList = computed(() => {
  if (!tour.value?.excluded) return [];
  return tour.value.excluded.split(',').map(e => e.trim());
});

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const handleBookNow = () => {
  if (!authStore.isAuthenticated) {
    router.push({ name: 'login', query: { redirect: route.fullPath } });
  } else {
    router.push({ name: 'booking', params: { id: tour.value.id } });
  }
};

onMounted(async () => {
  try {
    const response = await axios.get(`/api/v1/public/tours/${route.params.id}`);
    tour.value = response.data;
    currentImage.value = tour.value.image;
  } catch (error) {
    console.error('Error fetching tour:', error);
  } finally {
    loading.value = false;
  }
});
</script>

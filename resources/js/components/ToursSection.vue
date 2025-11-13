<template>
  <section id="tours" class="py-20 md:py-32 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-12" data-aos="fade-up">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Our Latest Tours & Travel Offers</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Discover handpicked travel experiences across Bangladesh
        </p>
        <div class="w-24 h-1 bg-gradient-emerald mx-auto mt-4"></div>
      </div>

      <!-- Filters -->
      <div class="flex flex-wrap justify-center gap-4 mb-12" data-aos="fade-up" data-aos-delay="100">
        <button
          v-for="filter in filters"
          :key="filter"
          @click="activeFilter = filter"
          :class="[
            'px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300',
            activeFilter === filter
              ? 'bg-gradient-emerald text-white shadow-lg'
              : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
          ]"
        >
          {{ filter }}
        </button>
      </div>

      <!-- Tours Grid -->
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="(tour, index) in filteredTours"
          :key="tour.id"
          class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg"
          data-aos="fade-up"
          :data-aos-delay="index * 100"
        >
          <!-- Tour Image -->
          <div class="relative h-64 overflow-hidden">
            <img :src="tour.image" :alt="tour.name" class="w-full h-full object-cover" />
            <div class="absolute top-4 right-4">
              <span class="bg-emerald-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                {{ tour.availability }}
              </span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
              <div class="flex items-center text-white text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ tour.location }}
              </div>
            </div>
          </div>

          <!-- Tour Info -->
          <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ tour.name }}</h3>
            <p class="text-gray-600 mb-4 text-sm line-clamp-2">{{ tour.description }}</p>

            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center text-gray-500 text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ tour.duration }}
              </div>
              <div class="flex items-center text-yellow-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <span class="ml-1 text-sm text-gray-600">{{ tour.rating }}</span>
              </div>
            </div>

            <div class="flex items-center justify-between">
              <div>
                <span class="text-2xl font-bold text-emerald-600">৳{{ typeof tour.price === 'number' ? tour.price.toLocaleString() : tour.price }}</span>
                <span class="text-gray-500 text-sm">/person</span>
              </div>
              <button
                @click="viewTourDetails(tour.id)"
                class="bg-gradient-emerald text-white px-6 py-2 rounded-full text-sm font-semibold hover:shadow-lg transition-all duration-200"
              >
                View Details
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Load More Button -->
      <div class="text-center mt-12" data-aos="fade-up">
        <button class="bg-gray-100 text-gray-700 px-8 py-3 rounded-full text-lg font-semibold hover:bg-gray-200 transition-all duration-200">
          Load More Tours
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const activeFilter = ref('All Tours');
const tours = ref([]);
const loading = ref(true);

const filters = computed(() => {
  const categories = ['All Tours', ...new Set(tours.value.map(t => t.category))];
  return categories;
});

const filteredTours = computed(() => {
  if (activeFilter.value === 'All Tours') {
    return tours.value;
  }
  return tours.value.filter(tour => tour.category === activeFilter.value);
});

const viewTourDetails = (tourId) => {
  router.push({ name: 'tour-details', params: { id: tourId } });
};

onMounted(async () => {
  try {
    const response = await axios.get('/api/v1/public/tours');
    tours.value = response.data.data || response.data;
  } catch (error) {
    console.error('Error fetching tours:', error);
  } finally {
    loading.value = false;
  }
});
</script>

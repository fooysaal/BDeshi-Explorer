<template>
  <section id="events" class="py-20 md:py-32 bg-gradient-to-br from-emerald-50 to-sky-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-12" data-aos="fade-up">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Ongoing & Recent Events</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Join our community of explorers and discover real travel stories
        </p>
        <div class="w-24 h-1 bg-gradient-emerald mx-auto mt-4"></div>
      </div>

      <!-- Events Carousel -->
      <div class="relative">
        <div class="overflow-hidden">
          <div
            class="flex transition-transform duration-500 ease-in-out"
            :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
          >
            <div
              v-for="event in events"
              :key="event.id"
              class="w-full flex-shrink-0 px-4"
            >
              <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-4xl mx-auto">
                <div class="md:flex">
                  <!-- Event Image -->
                  <div class="md:w-1/2">
                    <img
                      :src="event.image"
                      :alt="event.title"
                      class="w-full h-full object-cover min-h-[300px]"
                    />
                  </div>

                  <!-- Event Details -->
                  <div class="md:w-1/2 p-8">
                    <div class="flex items-center mb-4">
                      <span :class="[
                        'px-3 py-1 rounded-full text-sm font-semibold',
                        event.status === 'Ongoing' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'
                      ]">
                        {{ event.status }}
                      </span>
                    </div>

                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">{{ event.title }}</h3>
                    <p class="text-gray-600 mb-6">{{ event.description }}</p>

                    <div class="space-y-3 mb-6">
                      <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Hosted by <strong>{{ event.organizer }}</strong></span>
                      </div>

                      <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ event.date }}</span>
                      </div>

                      <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ event.location }}</span>
                      </div>

                      <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>{{ event.participants }} participants</span>
                      </div>
                    </div>

                    <button class="bg-gradient-emerald text-white px-6 py-3 rounded-full text-sm font-semibold hover:shadow-lg transition-all duration-200 w-full md:w-auto">
                      {{ event.status === 'Ongoing' ? 'Join Event' : 'View Highlights' }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Navigation Buttons -->
        <button
          @click="prevSlide"
          class="absolute left-0 top-1/2 -translate-y-1/2 bg-white p-3 rounded-full shadow-lg hover:bg-gray-100 transition-all duration-200 z-10"
          :disabled="currentSlide === 0"
          :class="{ 'opacity-50 cursor-not-allowed': currentSlide === 0 }"
        >
          <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>

        <button
          @click="nextSlide"
          class="absolute right-0 top-1/2 -translate-y-1/2 bg-white p-3 rounded-full shadow-lg hover:bg-gray-100 transition-all duration-200 z-10"
          :disabled="currentSlide === events.length - 1"
          :class="{ 'opacity-50 cursor-not-allowed': currentSlide === events.length - 1 }"
        >
          <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>

        <!-- Dots Indicator -->
        <div class="flex justify-center mt-8 space-x-2">
          <button
            v-for="(event, index) in events"
            :key="index"
            @click="currentSlide = index"
            :class="[
              'w-3 h-3 rounded-full transition-all duration-200',
              currentSlide === index ? 'bg-emerald-500 w-8' : 'bg-gray-300'
            ]"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const currentSlide = ref(0);
let autoPlayInterval = null;

const events = [
  {
    id: 1,
    title: 'Sundarbans Photography Expedition',
    description: 'A 3-day photography tour capturing the wild beauty of the Sundarbans mangrove forest. Join fellow photographers and wildlife enthusiasts.',
    organizer: 'Bangladesh Wildlife Society',
    date: 'November 20-22, 2025',
    location: 'Sundarbans, Khulna',
    participants: '45',
    status: 'Ongoing',
    image: 'https://images.unsplash.com/photo-1452421822248-d4c2b47f0c81?w=800&q=80'
  },
  {
    id: 2,
    title: 'Cultural Heritage Walk - Old Dhaka',
    description: 'Explore the historical streets of Old Dhaka, visit ancient mosques, and taste authentic street food with local historians.',
    organizer: 'Heritage Bangladesh',
    date: 'November 5, 2025',
    location: 'Old Dhaka',
    participants: '120',
    status: 'Completed',
    image: 'https://images.unsplash.com/photo-1569949381669-ecf31ae8e613?w=800&q=80'
  },
  {
    id: 3,
    title: 'Chittagong Hill Tracts Trekking',
    description: 'Adventure trekking through the stunning hills of Bandarban, meeting indigenous communities and experiencing their unique culture.',
    organizer: 'Adventure Club BD',
    date: 'November 15-18, 2025',
    location: 'Bandarban Hill Tracts',
    participants: '30',
    status: 'Ongoing',
    image: 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=800&q=80'
  },
  {
    id: 4,
    title: 'Tea Garden Festival',
    description: 'Experience the lush tea gardens of Sylhet, learn about tea production, and enjoy cultural performances.',
    organizer: 'Sylhet Tourism Board',
    date: 'October 28, 2025',
    location: 'Sylhet Tea Gardens',
    participants: '200',
    status: 'Completed',
    image: 'https://images.unsplash.com/photo-1563789031959-4c02bcb41319?w=800&q=80'
  }
];

const nextSlide = () => {
  if (currentSlide.value < events.length - 1) {
    currentSlide.value++;
  }
};

const prevSlide = () => {
  if (currentSlide.value > 0) {
    currentSlide.value--;
  }
};

const startAutoPlay = () => {
  autoPlayInterval = setInterval(() => {
    if (currentSlide.value < events.length - 1) {
      currentSlide.value++;
    } else {
      currentSlide.value = 0;
    }
  }, 5000);
};

const stopAutoPlay = () => {
  if (autoPlayInterval) {
    clearInterval(autoPlayInterval);
  }
};

onMounted(() => {
  startAutoPlay();
});

onUnmounted(() => {
  stopAutoPlay();
});
</script>

<template>
  <section class="relative py-32 overflow-hidden parallax" style="background-image: url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920&q=80')">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/90 to-sky-900/90"></div>

    <!-- Content -->
    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <div data-aos="zoom-in">
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
          Ready to Start Your Next Adventure?
        </h2>
        <p class="text-xl md:text-2xl text-white/90 mb-10 max-w-3xl mx-auto">
          Join thousands of explorers who have discovered the beauty of Bangladesh with us
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
          <a
            href="#tours"
            class="bg-white text-emerald-600 px-8 py-4 rounded-full text-lg font-semibold hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 inline-flex items-center space-x-2"
          >
            <span>Explore Tours</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
            </svg>
          </a>

          <a
            href="#contact"
            class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white hover:text-emerald-600 transform hover:-translate-y-1 transition-all duration-300 inline-flex items-center space-x-2"
          >
            <span>Become a Partner</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16 max-w-4xl mx-auto">
          <div
            v-for="(stat, index) in stats"
            :key="index"
            data-aos="fade-up"
            :data-aos-delay="index * 100"
          >
            <div class="text-4xl md:text-5xl font-bold text-white mb-2">{{ stat.value }}</div>
            <div class="text-white/80">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const stats = [
  { value: '15K+', label: 'Happy Travelers' },
  { value: '200+', label: 'Tour Packages' },
  { value: '50+', label: 'Destinations' },
  { value: '4.9', label: 'Average Rating' }
];
</script>

<template>
  <section id="home" class="relative h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Image/Video -->
    <div class="absolute inset-0 z-0">
      <img
        src="https://images.unsplash.com/photo-1609137144813-7d9921338f24?w=1920&q=80"
        alt="Bangladesh Travel"
        class="w-full h-full object-cover"
      />
      <div class="absolute inset-0 bg-gradient-overlay"></div>
      <div class="hero-overlay absolute inset-0"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <div data-aos="fade-up" data-aos-delay="100">
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
          Discover Bangladesh<br />
          <span class="text-gradient" style="-webkit-text-fill-color: #2ECC71;">Like Never Before</span>
        </h1>
      </div>

      <div data-aos="fade-up" data-aos-delay="300">
        <p class="text-xl md:text-2xl text-white/90 mb-10 max-w-3xl mx-auto font-light">
          Find, book, and explore authentic travel experiences across the country.
        </p>
      </div>

      <div
        data-aos="fade-up"
        data-aos-delay="500"
        class="flex flex-col sm:flex-row gap-4 justify-center items-center"
      >
        <a
          href="#tours"
          @click.prevent="scrollToSection('tours')"
          class="bg-gradient-emerald text-white px-8 py-4 rounded-full text-lg font-semibold hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 inline-flex items-center space-x-2"
        >
          <span>Explore Tours</span>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </a>

        <a
          href="#tours"
          @click.prevent="scrollToSection('tours')"
          class="bg-white/10 backdrop-blur-sm border-2 border-white text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white hover:text-gray-900 transform hover:-translate-y-1 transition-all duration-300 inline-flex items-center space-x-2"
        >
          <span>Book Your Next Trip</span>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </a>
      </div>

      <!-- Scroll Indicator -->
      <div
        data-aos="fade-up"
        data-aos-delay="700"
        class="absolute bottom-10 left-1/2 transform -translate-x-1/2"
      >
        <div class="flex flex-col items-center text-white/80 cursor-pointer hover:text-white transition-colors" @click="scrollToNext">
          <span class="text-sm mb-2">Scroll to explore</span>
          <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
          </svg>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const scrollToSection = (sectionId) => {
  const element = document.getElementById(sectionId);
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

const scrollToNext = () => {
  scrollToSection('about');
};
</script>

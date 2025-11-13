<template>
  <section id="about" class="py-20 md:py-32 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-16" data-aos="fade-up">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Who We Are</h2>
        <div class="w-24 h-1 bg-gradient-emerald mx-auto"></div>
      </div>

      <!-- Split Layout -->
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <!-- Image -->
        <div data-aos="fade-right">
          <div class="relative rounded-2xl overflow-hidden shadow-2xl">
            <img
              src="https://images.unsplash.com/photo-1553913861-c0fddf2619ee?w=800&q=80"
              alt="About Bdeshi Explorer"
              class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-gradient-emerald opacity-10"></div>
          </div>
        </div>

        <!-- Content -->
        <div data-aos="fade-left">
          <h3 class="text-3xl font-bold text-gray-900 mb-6">
            Connecting Travelers with Authentic Bangladeshi Experiences
          </h3>
          <p class="text-lg text-gray-600 mb-8 leading-relaxed">
            At Bdeshi Explorer, we're passionate about showcasing the incredible beauty, rich culture,
            and warm hospitality of Bangladesh. Our mission is to make authentic travel experiences
            accessible to everyone, whether you're a local explorer or an international adventurer.
          </p>

          <!-- Feature Highlights -->
          <div class="grid sm:grid-cols-2 gap-6">
            <div
              v-for="(feature, index) in features"
              :key="index"
              class="flex items-start space-x-4"
              :data-aos="'fade-up'"
              :data-aos-delay="index * 100"
            >
              <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-gradient-emerald rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="feature.icon" />
                  </svg>
                </div>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ feature.title }}</h4>
                <p class="text-gray-600 text-sm">{{ feature.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const features = [
  {
    title: 'Trusted Travel Partners',
    description: 'Verified and reliable tour operators',
    icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
  },
  {
    title: 'Safe & Secure Booking',
    description: 'Your transactions are fully protected',
    icon: 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'
  },
  {
    title: '24/7 Customer Support',
    description: 'We\'re here whenever you need us',
    icon: 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'
  },
  {
    title: 'Verified Local Guides',
    description: 'Expert guides who know Bangladesh best',
    icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
  }
];
</script>

<template>
  <section id="testimonials" class="py-20 md:py-32 bg-gradient-to-br from-sky-50 to-emerald-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-16" data-aos="fade-up">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">From Our Explorers</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Real stories from travelers who discovered Bangladesh with us
        </p>
        <div class="w-24 h-1 bg-gradient-emerald mx-auto mt-4"></div>
      </div>

      <!-- Testimonials Grid -->
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="(testimonial, index) in testimonials"
          :key="testimonial.id"
          class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300"
          data-aos="fade-up"
          :data-aos-delay="index * 100"
        >
          <!-- Rating -->
          <div class="flex items-center mb-4">
            <svg
              v-for="star in 5"
              :key="star"
              :class="star <= testimonial.rating ? 'text-yellow-400' : 'text-gray-300'"
              class="w-5 h-5"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>

          <!-- Quote -->
          <p class="text-gray-700 mb-6 italic leading-relaxed">
            "{{ testimonial.quote }}"
          </p>

          <!-- Traveler Info -->
          <div class="flex items-center">
            <img
              :src="testimonial.avatar"
              :alt="testimonial.name"
              class="w-14 h-14 rounded-full object-cover mr-4"
            />
            <div>
              <h4 class="font-semibold text-gray-900">{{ testimonial.name }}</h4>
              <p class="text-sm text-gray-500">{{ testimonial.location }}</p>
            </div>
          </div>

          <!-- Tour Tag -->
          <div class="mt-4 pt-4 border-t border-gray-200">
            <span class="text-xs text-emerald-600 font-medium">
              {{ testimonial.tour }}
            </span>
          </div>
        </div>
      </div>

      <!-- Read More Button -->
      <div class="text-center mt-12" data-aos="fade-up">
        <button class="bg-gradient-emerald text-white px-8 py-3 rounded-full text-lg font-semibold hover:shadow-lg transition-all duration-200 inline-flex items-center space-x-2">
          <span>Read More Stories</span>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
const testimonials = [
  {
    id: 1,
    name: 'Sarah Johnson',
    location: 'United Kingdom',
    avatar: 'https://i.pravatar.cc/150?img=1',
    rating: 5,
    quote: 'The Sundarbans tour was absolutely breathtaking! Our guide was knowledgeable and the entire experience was well-organized. I highly recommend Bdeshi Explorer for anyone wanting to explore Bangladesh.',
    tour: 'Sundarbans Mangrove Adventure'
  },
  {
    id: 2,
    name: 'Rahim Ahmed',
    location: 'Dhaka, Bangladesh',
    avatar: 'https://i.pravatar.cc/150?img=12',
    rating: 5,
    quote: 'As a local, I thought I knew Bangladesh well, but this tour showed me places I\'d never seen before. The tea gardens of Sylhet are magical, and the hospitality was exceptional.',
    tour: 'Sylhet Tea Garden Retreat'
  },
  {
    id: 3,
    name: 'Michael Chen',
    location: 'Singapore',
    avatar: 'https://i.pravatar.cc/150?img=13',
    rating: 4,
    quote: 'Cox\'s Bazar exceeded all expectations! The beach is stunning, the food was amazing, and the sunset views were unforgettable. Great value for money.',
    tour: 'Cox\'s Bazar Beach Paradise'
  },
  {
    id: 4,
    name: 'Priya Sharma',
    location: 'India',
    avatar: 'https://i.pravatar.cc/150?img=5',
    rating: 5,
    quote: 'The cultural tour of Old Dhaka was a wonderful journey through history. The local guides shared fascinating stories and the food tour was incredible!',
    tour: 'Historical Dhaka City Tour'
  },
  {
    id: 5,
    name: 'David Thompson',
    location: 'Australia',
    avatar: 'https://i.pravatar.cc/150?img=14',
    rating: 5,
    quote: 'Bandarban hill tracts trek was the adventure of a lifetime. The scenery is spectacular and meeting the local tribes was a unique cultural experience.',
    tour: 'Bandarban Hill Tracts'
  },
  {
    id: 6,
    name: 'Fatima Khan',
    location: 'Chittagong, Bangladesh',
    avatar: 'https://i.pravatar.cc/150?img=9',
    rating: 4,
    quote: 'Kuakata beach is a hidden gem! Watching both sunrise and sunset from the same place was magical. The tour was well-paced and comfortable.',
    tour: 'Kuakata Sea Beach'
  }
];
</script>

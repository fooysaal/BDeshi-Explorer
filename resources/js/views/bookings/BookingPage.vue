<template>
  <div class="min-h-screen bg-gray-50">
    <NavigationMenu />

    <div class="container mx-auto px-4 py-24">
      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center h-96">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-emerald-600"></div>
      </div>

      <!-- Booking Form -->
      <div v-else-if="tour" class="max-w-5xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Book Your Tour</h1>
        <p class="text-gray-600 mb-8">Complete the form below to book your adventure</p>

        <div class="grid md:grid-cols-3 gap-8">
          <!-- Booking Form -->
          <div class="md:col-span-2 bg-white rounded-2xl shadow-xl p-8">
            <form @submit.prevent="handleSubmit">
              <!-- Tour Info (Read-only) -->
              <div class="mb-6 p-4 bg-emerald-50 rounded-lg">
                <h3 class="font-semibold text-emerald-800 mb-2">{{ tour.name }}</h3>
                <p class="text-sm text-emerald-700">{{ tour.location }} • {{ tour.duration }}</p>
              </div>

              <!-- Number of Participants -->
              <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Number of Participants *</label>
                <input
                  v-model.number="form.number_of_participants"
                  type="number"
                  min="1"
                  :max="tour.available_capacity"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                  @input="calculateTotal"
                />
                <p class="text-sm text-gray-500 mt-1">Available slots: {{ tour.available_capacity }}</p>
                <p v-if="errors.number_of_participants" class="text-red-500 text-sm mt-1">{{ errors.number_of_participants[0] }}</p>
              </div>

              <!-- Payment Method -->
              <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Payment Method *</label>
                <select
                  v-model="form.payment_method"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                  @change="handlePaymentMethodChange"
                >
                  <option value="">Select payment method</option>
                  <option value="bank_transfer">Bank Transfer</option>
                  <option value="mfs_service">Mobile Financial Service (MFS)</option>
                  <option value="pay_later">Pay Later</option>
                </select>
                <p v-if="errors.payment_method" class="text-red-500 text-sm mt-1">{{ errors.payment_method[0] }}</p>
              </div>

              <!-- MFS Provider (if MFS selected) -->
              <div v-if="form.payment_method === 'mfs_service'" class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">MFS Provider *</label>
                <select
                  v-model="form.mfs_provider"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                >
                  <option value="">Select MFS provider</option>
                  <option value="bkash">bKash</option>
                  <option value="nagad">Nagad</option>
                  <option value="rocket">Rocket</option>
                </select>
                <p v-if="errors.mfs_provider" class="text-red-500 text-sm mt-1">{{ errors.mfs_provider[0] }}</p>
              </div>

              <!-- Transaction ID (if not pay later) -->
              <div v-if="form.payment_method && form.payment_method !== 'pay_later'" class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Transaction ID *</label>
                <input
                  v-model="form.transaction_id"
                  type="text"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                  placeholder="Enter your transaction ID"
                />
                <p class="text-sm text-gray-500 mt-1">Provide the transaction reference number</p>
                <p v-if="errors.transaction_id" class="text-red-500 text-sm mt-1">{{ errors.transaction_id[0] }}</p>
              </div>

              <!-- Payment Receipt (Optional) -->
              <div v-if="form.payment_method && form.payment_method !== 'pay_later'" class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Payment Receipt (Optional)</label>
                <input
                  v-model="form.payment_receipt"
                  type="text"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                  placeholder="Upload link or reference"
                />
                <p class="text-sm text-gray-500 mt-1">You can upload receipt link or file reference</p>
              </div>

              <!-- Special Requests -->
              <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Special Requests (Optional)</label>
                <textarea
                  v-model="form.special_requests"
                  rows="4"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                  placeholder="Any special requirements or requests?"
                ></textarea>
              </div>

              <!-- Error Message -->
              <div v-if="errorMessage" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                {{ errorMessage }}
              </div>

              <!-- Success Message -->
              <div v-if="successMessage" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                {{ successMessage }}
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                :disabled="submitting"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 px-6 rounded-xl transition duration-300 disabled:opacity-50"
              >
                <span v-if="!submitting">Confirm Booking</span>
                <span v-else>Processing...</span>
              </button>
            </form>
          </div>

          <!-- Booking Summary -->
          <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-24">
              <h3 class="text-xl font-bold text-gray-900 mb-4">Booking Summary</h3>

              <div class="space-y-3 mb-6">
                <div class="flex justify-between">
                  <span class="text-gray-600">Price per person</span>
                  <span class="font-semibold">৳{{ tour.price.toLocaleString() }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-600">Participants</span>
                  <span class="font-semibold">× {{ form.number_of_participants }}</span>
                </div>
                <div class="border-t pt-3 flex justify-between">
                  <span class="text-lg font-bold">Total Amount</span>
                  <span class="text-2xl font-bold text-emerald-600">৳{{ totalPrice.toLocaleString() }}</span>
                </div>
              </div>

              <div class="bg-sky-50 p-4 rounded-lg text-sm">
                <p class="font-semibold text-gray-700 mb-2">📌 Important Notes:</p>
                <ul class="space-y-1 text-gray-600">
                  <li>• Your booking requires admin approval</li>
                  <li>• You'll receive confirmation via email</li>
                  <li>• Payment must be verified before approval</li>
                  <li>• Refund policy applies for cancellations</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <FooterSection />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import NavigationMenu from '../../components/NavigationMenu.vue';
import FooterSection from '../../components/FooterSection.vue';

const route = useRoute();
const router = useRouter();

const tour = ref(null);
const loading = ref(true);
const submitting = ref(false);

const form = ref({
  tour_id: route.params.id,
  number_of_participants: 1,
  payment_method: '',
  mfs_provider: '',
  transaction_id: '',
  payment_receipt: '',
  special_requests: ''
});

const errors = ref({});
const errorMessage = ref('');
const successMessage = ref('');

const totalPrice = computed(() => {
  return (tour.value?.price || 0) * form.value.number_of_participants;
});

const calculateTotal = () => {
  // Recalculates total when participants change
};

const handlePaymentMethodChange = () => {
  // Reset MFS provider if payment method changes
  if (form.value.payment_method !== 'mfs_service') {
    form.value.mfs_provider = '';
  }
  // Reset transaction ID if pay later
  if (form.value.payment_method === 'pay_later') {
    form.value.transaction_id = '';
  }
};

const handleSubmit = async () => {
  submitting.value = true;
  errors.value = {};
  errorMessage.value = '';
  successMessage.value = '';

  try {
    const response = await axios.post('/api/v1/bookings', form.value);

    successMessage.value = 'Booking submitted successfully! Redirecting to your bookings...';

    setTimeout(() => {
      router.push('/my-bookings');
    }, 2000);
  } catch (error) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors;
    } else {
      errorMessage.value = error.response?.data?.message || 'Booking failed. Please try again.';
    }
  } finally {
    submitting.value = false;
  }
};

onMounted(async () => {
  try {
    const response = await axios.get(`/api/v1/public/tours/${route.params.id}`);
    tour.value = response.data;
    form.value.tour_id = tour.value.id;
  } catch (error) {
    console.error('Error fetching tour:', error);
    router.push('/');
  } finally {
    loading.value = false;
  }
});
</script>

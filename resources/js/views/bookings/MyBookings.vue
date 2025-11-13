<template>
  <div class="min-h-screen bg-gray-50">
    <NavigationMenu />

    <div class="container mx-auto px-4 py-24">
      <h1 class="text-4xl font-bold text-gray-900 mb-2">My Bookings</h1>
      <p class="text-gray-600 mb-8">View and manage your tour bookings</p>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-emerald-600"></div>
      </div>

      <!-- Bookings List -->
      <div v-else-if="bookings.length > 0" class="space-y-6">
        <div
          v-for="booking in bookings"
          :key="booking.id"
          class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition"
        >
          <div class="md:flex">
            <!-- Tour Image -->
            <div class="md:w-1/4">
              <img
                :src="booking.tour?.image"
                :alt="booking.tour?.name"
                class="w-full h-48 md:h-full object-cover"
              />
            </div>

            <!-- Booking Details -->
            <div class="md:w-3/4 p-6">
              <div class="flex justify-between items-start mb-4">
                <div>
                  <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ booking.tour?.name }}</h3>
                  <p class="text-gray-600">{{ booking.tour?.location }}</p>
                </div>
                <span
                  class="px-4 py-2 rounded-full text-sm font-semibold"
                  :class="getStatusClass(booking.status)"
                >
                  {{ formatStatus(booking.status) }}
                </span>
              </div>

              <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                  <p class="text-sm text-gray-500">Booking Number</p>
                  <p class="font-semibold">{{ booking.booking_number }}</p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Participants</p>
                  <p class="font-semibold">{{ booking.number_of_participants }} person(s)</p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Total Amount</p>
                  <p class="font-semibold text-emerald-600">৳{{ booking.total_price.toLocaleString() }}</p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Payment Method</p>
                  <p class="font-semibold">{{ formatPaymentMethod(booking.payment_method) }}</p>
                </div>
                <div v-if="booking.mfs_provider">
                  <p class="text-sm text-gray-500">MFS Provider</p>
                  <p class="font-semibold uppercase">{{ booking.mfs_provider }}</p>
                </div>
                <div v-if="booking.transaction_id">
                  <p class="text-sm text-gray-500">Transaction ID</p>
                  <p class="font-semibold">{{ booking.transaction_id }}</p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Booked On</p>
                  <p class="font-semibold">{{ formatDate(booking.created_at) }}</p>
                </div>
                <div v-if="booking.approved_at">
                  <p class="text-sm text-gray-500">Approved On</p>
                  <p class="font-semibold">{{ formatDate(booking.approved_at) }}</p>
                </div>
              </div>

              <!-- Special Requests -->
              <div v-if="booking.special_requests" class="mb-4 p-3 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">Special Requests</p>
                <p class="text-sm text-gray-700">{{ booking.special_requests }}</p>
              </div>

              <!-- Admin Notes -->
              <div v-if="booking.admin_notes" class="mb-4 p-3 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-700 mb-1">📝 Admin Notes</p>
                <p class="text-sm text-blue-900">{{ booking.admin_notes }}</p>
              </div>

              <!-- Cancellation Reason -->
              <div v-if="booking.cancellation_reason" class="mb-4 p-3 bg-red-50 rounded-lg">
                <p class="text-sm text-red-700 mb-1">Cancellation Reason</p>
                <p class="text-sm text-red-900">{{ booking.cancellation_reason }}</p>
              </div>

              <!-- Actions -->
              <div class="flex gap-3">
                <button
                  v-if="booking.status === 'pending' && booking.payment_method !== 'pay_later'"
                  @click="updatePayment(booking)"
                  class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm"
                >
                  Update Payment
                </button>
                <button
                  v-if="booking.status !== 'completed' && booking.status !== 'cancelled'"
                  @click="cancelBooking(booking)"
                  class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm"
                >
                  Cancel Booking
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-16">
        <div class="text-6xl mb-4">📅</div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">No Bookings Yet</h2>
        <p class="text-gray-600 mb-6">Start your adventure by booking a tour!</p>
        <router-link
          to="/#tours"
          class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl transition"
        >
          Explore Tours
        </router-link>
      </div>
    </div>

    <FooterSection />

    <!-- Cancel Modal -->
    <div v-if="showCancelModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-2xl p-8 max-w-md w-full">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Cancel Booking</h3>
        <p class="text-gray-600 mb-4">Please provide a reason for cancellation:</p>

        <textarea
          v-model="cancelReason"
          rows="4"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 mb-4"
          placeholder="Why are you cancelling this booking?"
        ></textarea>

        <div class="flex gap-3">
          <button
            @click="confirmCancel"
            :disabled="!cancelReason || cancelling"
            class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition disabled:opacity-50"
          >
            {{ cancelling ? 'Cancelling...' : 'Confirm Cancel' }}
          </button>
          <button
            @click="showCancelModal = false"
            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition"
          >
            Keep Booking
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import NavigationMenu from '../../components/NavigationMenu.vue';
import FooterSection from '../../components/FooterSection.vue';

const router = useRouter();

const bookings = ref([]);
const loading = ref(true);
const showCancelModal = ref(false);
const selectedBooking = ref(null);
const cancelReason = ref('');
const cancelling = ref(false);

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

const formatPaymentMethod = (method) => {
  const methods = {
    bank_transfer: 'Bank Transfer',
    mfs_service: 'Mobile Financial Service',
    pay_later: 'Pay Later'
  };
  return methods[method] || method;
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const updatePayment = (booking) => {
  // Navigate to payment update page or show modal
  alert('Payment update feature coming soon!');
};

const cancelBooking = (booking) => {
  selectedBooking.value = booking;
  showCancelModal.value = true;
};

const confirmCancel = async () => {
  if (!cancelReason.value) return;

  cancelling.value = true;

  try {
    await axios.post(`/api/v1/bookings/${selectedBooking.value.id}/cancel`, {
      cancellation_reason: cancelReason.value
    });

    // Refresh bookings
    await fetchBookings();

    showCancelModal.value = false;
    cancelReason.value = '';
    selectedBooking.value = null;
  } catch (error) {
    alert(error.response?.data?.message || 'Failed to cancel booking');
  } finally {
    cancelling.value = false;
  }
};

const fetchBookings = async () => {
  try {
    const response = await axios.get('/api/v1/bookings');
    bookings.value = response.data.data || response.data;
  } catch (error) {
    console.error('Error fetching bookings:', error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchBookings();
});
</script>

import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

// Landing Page Components
import LandingPage from '../components/LandingPage.vue';

// Auth Components
import Login from '../views/auth/Login.vue';
import Register from '../views/auth/Register.vue';

// Tour Components
import TourDetails from '../views/tours/TourDetails.vue';

// Booking Components
import BookingPage from '../views/bookings/BookingPage.vue';
import MyBookings from '../views/bookings/MyBookings.vue';

// User Dashboard
import UserDashboard from '../views/dashboard/UserDashboard.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: LandingPage,
        meta: { title: 'Bdeshi Explorer - Discover Bangladesh' }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { title: 'Login - Bdeshi Explorer', guest: true }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: { title: 'Register - Bdeshi Explorer', guest: true }
    },
    {
        path: '/tours/:id',
        name: 'tour-details',
        component: TourDetails,
        meta: { title: 'Tour Details - Bdeshi Explorer' }
    },
    {
        path: '/tours/:id/book',
        name: 'booking',
        component: BookingPage,
        meta: { title: 'Book Tour - Bdeshi Explorer', requiresAuth: true }
    },
    {
        path: '/my-bookings',
        name: 'my-bookings',
        component: MyBookings,
        meta: { title: 'My Bookings - Bdeshi Explorer', requiresAuth: true }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: UserDashboard,
        meta: { title: 'Dashboard - Bdeshi Explorer', requiresAuth: true }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else if (to.hash) {
            return { el: to.hash, behavior: 'smooth' };
        } else {
            return { top: 0, behavior: 'smooth' };
        }
    }
});

// Navigation guards
router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    // Update document title
    document.title = to.meta.title || 'Bdeshi Explorer';

    // Check if route requires authentication
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next({ name: 'login', query: { redirect: to.fullPath } });
    }
    // Check if route is for guests only (login/register)
    else if (to.meta.guest && authStore.isAuthenticated) {
        next({ name: 'home' });
    }
    else {
        next();
    }
});

export default router;

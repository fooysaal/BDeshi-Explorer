import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('token') || null,
        loading: false,
        error: null
    }),

    getters: {
        isAuthenticated: (state) => !!state.token,
        isAdmin: (state) => state.user?.role === 'admin',
        isModerator: (state) => state.user?.role === 'moderator',
        isExplorer: (state) => state.user?.role === 'explorer',
        canManage: (state) => state.user?.role === 'admin' || state.user?.role === 'moderator'
    },

    actions: {
        async register(userData) {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.post('/api/v1/register', userData);

                this.user = response.data.user;
                this.token = response.data.token;

                localStorage.setItem('token', this.token);
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

                return response.data;
            } catch (error) {
                this.error = error.response?.data?.errors || error.message;
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async login(credentials) {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.post('/api/v1/login', credentials);

                this.user = response.data.user;
                this.token = response.data.token;

                localStorage.setItem('token', this.token);
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

                return response.data;
            } catch (error) {
                this.error = error.response?.data?.errors || error.message;
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async logout() {
            try {
                await axios.post('/api/v1/logout');
            } catch (error) {
                console.error('Logout error:', error);
            } finally {
                this.user = null;
                this.token = null;
                localStorage.removeItem('token');
                delete axios.defaults.headers.common['Authorization'];
            }
        },

        async fetchUser() {
            if (!this.token) return;

            try {
                const response = await axios.get('/api/v1/user');
                this.user = response.data;
            } catch (error) {
                // Token might be invalid
                this.logout();
            }
        },

        async updateProfile(profileData) {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.put('/api/v1/profile', profileData);
                this.user = response.data.user;
                return response.data;
            } catch (error) {
                this.error = error.response?.data?.errors || error.message;
                throw error;
            } finally {
                this.loading = false;
            }
        },

        initAuth() {
            if (this.token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                this.fetchUser();
            }
        }
    }
});

// API Configuration
export const API_BASE = import.meta.env.VITE_API_BASE || 'http://localhost:8000/api/v1';
export const APP_NAME = 'IND-MAAV E-Commerce';

// Routes
export const ROUTES = {
  HOME: 'home',
  LOGIN: 'login',
  REGISTER: 'register',
  PRODUCTS: 'products',
};

// Storage Keys
export const STORAGE_KEYS = {
  TOKEN: 'auth_token',
  USER: 'user',
};

// UI Constants
export const UI = {
  COLORS: {
    PRIMARY: '#007bff',
    SUCCESS: '#28a745',
    DANGER: '#dc3545',
    SECONDARY: '#6c757d',
    LIGHT: '#f9f9f9',
  },
  PADDING: {
    SMALL: '5px 10px',
    MEDIUM: '10px 15px',
    LARGE: '15px 20px',
  },
};

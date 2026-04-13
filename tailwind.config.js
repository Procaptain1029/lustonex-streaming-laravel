import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/css/**/*.css',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Poppins', 'Roboto', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Dark theme base colors
                dark: {
                    900: '#0a0a0a',
                    800: '#1a1a1a',
                    700: '#2a2a2a',
                    600: '#3a3a3a',
                    500: '#4a4a4a',
                    400: '#6a6a6a',
                    300: '#8a8a8a',
                    200: '#aaaaaa',
                    100: '#cccccc',
                },
                // Premium accent colors
                primary: {
                    50: '#fef2f2',
                    100: '#fee2e2',
                    200: '#fecaca',
                    300: '#fca5a5',
                    400: '#f87171',
                    500: '#e50914', // Netflix red
                    600: '#dc2626',
                    700: '#b91c1c',
                    800: '#991b1b',
                    900: '#7f1d1d',
                },
                fire: {
                    50: '#fff7ed',
                    100: '#ffedd5',
                    200: '#fed7aa',
                    300: '#fdba74',
                    400: '#fb923c',
                    500: '#ff4500', // Fire orange
                    600: '#ea580c',
                    700: '#c2410c',
                    800: '#9a3412',
                    900: '#7c2d12',
                },
                gold: {
                    50: '#fefce8',
                    100: '#fef9c3',
                    200: '#fef08a',
                    300: '#fde047',
                    400: '#facc15',
                    500: '#f5c518', // IMDb gold
                    600: '#ca8a04',
                    700: '#a16207',
                    800: '#854d0e',
                    900: '#713f12',
                },
            },
            animation: {
                'pulse-glow': 'pulse-glow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'slide-in': 'slide-in 0.3s ease-out',
                'fade-in': 'fade-in 0.2s ease-out',
                'glow': 'glow 1.5s ease-in-out infinite alternate',
            },
            keyframes: {
                'pulse-glow': {
                    '0%, 100%': {
                        opacity: '1',
                        boxShadow: '0 0 5px rgb(229, 9, 20), 0 0 10px rgb(229, 9, 20), 0 0 15px rgb(229, 9, 20)',
                    },
                    '50%': {
                        opacity: '0.8',
                        boxShadow: '0 0 2px rgb(229, 9, 20), 0 0 5px rgb(229, 9, 20), 0 0 8px rgb(229, 9, 20)',
                    },
                },
                'slide-in': {
                    '0%': {
                        transform: 'translateX(100%)',
                        opacity: '0',
                    },
                    '100%': {
                        transform: 'translateX(0)',
                        opacity: '1',
                    },
                },
                'fade-in': {
                    '0%': {
                        opacity: '0',
                        transform: 'translateY(-10px)',
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateY(0)',
                    },
                },
                'glow': {
                    '0%': {
                        boxShadow: '0 0 5px rgb(229, 9, 20)',
                    },
                    '100%': {
                        boxShadow: '0 0 20px rgb(229, 9, 20), 0 0 30px rgb(229, 9, 20)',
                    },
                },
            },
            backdropBlur: {
                xs: '2px',
            },
            boxShadow: {
                'glow-red': '0 0 15px rgba(229, 9, 20, 0.5)',
                'glow-orange': '0 0 15px rgba(255, 69, 0, 0.5)',
                'glow-gold': '0 0 15px rgba(245, 197, 24, 0.5)',
                'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.37)',
            },
        },
    },

    plugins: [forms],
};

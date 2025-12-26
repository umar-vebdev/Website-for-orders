import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/admin.js', // админский JS
            ],
            refresh: true, // автоматическая перезагрузка при изменении Blade
        }),
        tailwindcss(),
    ],
    server: {
        host: '127.0.0.1', // локальный адрес сервера разработки
        port: 5173,        // стандартный порт Vite
    },
});

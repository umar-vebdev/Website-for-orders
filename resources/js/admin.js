import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const ordersList = document.querySelector('#orders-list');
    if (!ordersList) return;

    const statusLabels = {
        'new': 'Новый',
        'processing': 'В обработке',
        'done': 'Выполнен',
        'cancelled': 'Отменён',
    };

    const statusColors = {
        'new': 'bg-blue-600 text-white',
        'processing': 'bg-yellow-500 text-black',
        'done': 'bg-green-600 text-white',
        'cancelled': 'bg-red-600 text-white',
    };

    // Подписка на канал "orders"
    window.Echo.channel('orders')
        .listen('.OrderCreated', (e) => {
            console.log('Новый заказ:', e);

            // Вставляем только базовую карточку (без формы)
            const row = document.createElement('div');
            row.classList.add(
                'order-card', 'flex', 'flex-wrap', 'items-center', 'gap-2',
                'p-3', 'bg-[#020617]/80', 'border', 'border-slate-800',
                'rounded-2xl', 'hover:bg-[#020617]', 'transition', 'w-full', 'overflow-hidden'
            );

            row.innerHTML = `
                <div class="w-14 h-14 flex-shrink-0 flex items-center justify-center bg-gray-800/50 rounded-xl text-white font-bold text-lg">
                    ${e.id}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-white font-semibold truncate text-sm sm:text-base">${e.name}</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium ${statusColors[e.status] || 'bg-gray-500 text-white'}">
                            ${statusLabels[e.status] || e.status}
                        </span>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-400 truncate">
                        ${e.phone} • ${new Date().toLocaleString()}
                    </div>
                    <div class="text-sm sm:text-lg font-semibold mt-1">${e.total_price} ₽</div>
                </div>
            `;

            ordersList.prepend(row);
        });
});

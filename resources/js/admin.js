import './bootstrap';

// Позволяет видеть события Pusher в консоли
window.Pusher.logToConsole = true;

document.addEventListener('DOMContentLoaded', () => {
    const ordersList = document.getElementById('orders-list');

    if (!ordersList) {
        console.log('Скрипт заказов спит: #orders-list не найден.');
        return;
    }

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

    console.log('Контейнер найден. Подписываемся на заказы...');

    window.Echo.channel('orders')
        .listen('.OrderCreated', (e) => {
            console.log('Событие получено!', e);

            // Удаляем сообщение "Заказов пока нет", если оно есть
            const noOrdersMsg = document.getElementById('no-orders-message');
            if (noOrdersMsg) noOrdersMsg.remove();

            const row = document.createElement('div');
            // Точный набор классов из вашего Blade
            row.className = 'order-card bg-[#020617]/80 border border-slate-800 rounded-2xl hover:bg-[#020617] transition p-3 w-full';

            // Форматируем дату как в Blade (d.m.Y H:i)
            const now = new Date();
            const dateStr = now.toLocaleDateString('ru-RU') + ' ' + 
                            now.toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' });

            // Подставляем данные в шаблон, идентичный вашему Blade
            row.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 flex items-center justify-center bg-gray-800/50 rounded-xl text-white font-bold text-lg flex-shrink-0">
                        ${e.id}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="text-white font-semibold truncate text-sm sm:text-base">${e.name}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium ${statusColors[e.status] || 'bg-gray-500 text-white'}">
                                ${statusLabels[e.status] || e.status}
                            </span>
                        </div>
                        <div class="text-xs sm:text-sm text-slate-400 truncate">
                            ${e.phone} • ${dateStr}
                        </div>
                        <div class="text-sm sm:text-lg font-semibold mt-1">${e.total_price} ₽</div>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-3">
                    <div class="flex items-center gap-1">
                        <div class="bg-gray-800 text-white text-xs rounded px-2 py-1 border border-slate-700">
                            Статус можно будет изменить после обновления страницы
                        </div>
                    </div>
                    <a href="/admin/orders/${e.id}" class="bg-gray-700/50 hover:bg-gray-700 text-blue-400 hover:text-blue-300 text-xs rounded px-2 py-1 transition flex items-center justify-center">
                        Просмотр
                    </a>
                </div>
            `;

            // Добавляем в начало списка
            ordersList.prepend(row);
        });
});

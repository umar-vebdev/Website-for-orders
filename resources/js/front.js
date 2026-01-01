import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const orders = document.querySelectorAll('[id^="order-status-container-"]');

    orders.forEach(orderBox => {
        const orderId = orderBox.dataset.orderId;
        const statusLabel = document.getElementById(`status-label-${orderId}`);

        if (!orderId || !statusLabel) return;

        console.log(`🚀 Подключаемся к каналу заказа: order.${orderId}`);

        // Включаем логирование Pusher
        window.Pusher.logToConsole = true;

        window.Echo.channel(`order.${orderId}`)
            .subscribed(() => {
                console.log(`✅ Подписка на канал заказа ${orderId} успешна`);
            })
            .listen('.StatusUpdated', (e) => {
                console.log('🔔 Статус обновлен!', e);

                statusLabel.innerText = e.status_label;

                // Сброс классов
                statusLabel.className = 'status-label px-3 py-1 rounded-xl text-sm font-medium';

                switch (e.status) {
                    case 'new':
                        statusLabel.classList.add('bg-blue-600/30', 'text-blue-300');
                        break;
                    case 'processing':
                        statusLabel.classList.add('bg-yellow-600/30', 'text-yellow-300');
                        break;
                    case 'done':
                        statusLabel.classList.add('bg-green-600/30', 'text-green-300');
                        break;
                    case 'cancelled':
                        statusLabel.classList.add('bg-red-600/30', 'text-red-300');
                        break;
                    default:
                        statusLabel.classList.add('bg-slate-600/30', 'text-slate-300');
                }

                statusLabel.classList.add('scale-110');
                setTimeout(() => statusLabel.classList.remove('scale-110'), 2000);
            })
            .error((err) => {
                console.error('❌ Ошибка Echo для заказа', orderId, err);
            });
    });
});

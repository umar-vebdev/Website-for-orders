import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const orders = document.querySelectorAll('[id^="order-status-container-"]');

    orders.forEach(orderBox => {
        const orderId = orderBox.dataset.orderId;
        const statusLabel = document.getElementById(`status-label-${orderId}`);

        if (!orderId || !statusLabel) return;

        console.log(`🚀 Подключаемся к каналу заказа: order.${orderId}`);

        // Включаем лог Pusher
        window.Pusher.logToConsole = true;

        window.Echo.channel(`order.${orderId}`)
            .subscribed(() => {
                console.log('✅ Успешно подписались на канал заказа!', orderId);
            })
            .listen('.StatusUpdated', (e) => {
                console.log('🔔 Статус обновлен!', e);

                if (statusLabel) {
                    statusLabel.innerText = e.status_label;

                    // Сбрасываем старые цвета
                    statusLabel.className = 'status-label px-3 py-1 rounded-xl text-sm font-medium';

                    // Добавляем новый цвет в зависимости от статуса
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

                    // Визуальный эффект
                    statusLabel.classList.add('scale-110');
                    setTimeout(() => {
                        statusLabel.classList.remove('scale-110');
                    }, 2000);
                }
            })
            .error((err) => {
                console.error('❌ Ошибка Echo для заказа', orderId, err);
            });
    });
});

import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Ищем контейнер с данными
    const orderBox = document.getElementById('order-status-container');
    
    if (!orderBox) {
        // Если элемента нет, значит мы не на странице заказа, просто выходим
        return;
    }

    const orderId = orderBox.dataset.orderId;
    const statusLabel = document.getElementById('status-label');

    console.log(`🚀 Подключаемся к каналу заказа: order.${orderId}`);

    // Включаем лог Pusher, чтобы видеть ошибки в консоли (только для отладки)
    window.Pusher.logToConsole = true;

    // 2. Слушаем публичный канал
    window.Echo.channel(`order.${orderId}`)
        .subscribed(() => {
            console.log('✅ Успешно подписались на канал заказа!');
        })
        .listen('.StatusUpdated', (e) => {
            console.log('🔔 Статус обновлен!', e);
            
            if (statusLabel) {
                // Обновляем текст статуса
                statusLabel.innerText = e.status_label;
                
                // Визуальный эффект (Tailwind)
                statusLabel.classList.add('text-green-500', 'scale-110');
                setTimeout(() => {
                    statusLabel.classList.remove('text-green-500', 'scale-110');
                }, 2000);
            }
        })
        .error((err) => {
            console.error('❌ Ошибка Echo:', err);
        });
});

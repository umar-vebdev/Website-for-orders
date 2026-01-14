import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // Ищем все контейнеры заказов
    const orders = document.querySelectorAll('[id^="order-status-container-"]');

    orders.forEach(orderBox => {
        const orderId = orderBox.dataset.orderId;
        
        // Элементы внутри карточки, которые будем менять
        const statusLabel = document.getElementById(`status-label-${orderId}`);
        const iconBg = document.getElementById(`icon-bg-${orderId}`);
        const iconI = document.getElementById(`icon-i-${orderId}`);

        if (!orderId || !statusLabel) return;

        // Подписываемся на приватный канал заказа
        window.Echo.channel(`order.${orderId}`)
            .listen('.StatusUpdated', (e) => {
                console.log('🔔 Статус обновлен!', e);

                // 1. Обновляем текст статуса (берем из события)
                statusLabel.innerText = e.status_label;

                // 2. Сброс базовых классов (согласно вашей Blade-верстке)
                // Для текста статуса
                statusLabel.className = 'status-label text-[10px] font-black uppercase tracking-widest transition-colors duration-500';
                
                // Для фона иконки
                if (iconBg) {
                    iconBg.className = 'w-12 h-12 rounded-full flex items-center justify-center shrink-0 transition-all duration-500 group-hover:scale-110';
                }
                
                // Для самой иконки
                if (iconI) {
                    iconI.className = 'fas text-sm transition-all duration-500';
                }

                // 3. Установка стилей в зависимости от статуса (копируем логику match из Blade)
                switch (e.status) {
                    case 'new':
                        statusLabel.classList.add('text-blue-400');
                        if (iconBg) iconBg.classList.add('bg-blue-500/10', 'text-blue-400');
                        if (iconI) iconI.classList.add('fa-bell');
                        break;
                    case 'processing':
                        statusLabel.classList.add('text-orange-400');
                        if (iconBg) iconBg.classList.add('bg-orange-500/10', 'text-orange-400');
                        if (iconI) iconI.classList.add('fa-fire');
                        break;
                    case 'done':
                        statusLabel.classList.add('text-green-400');
                        if (iconBg) iconBg.classList.add('bg-green-500/10', 'text-green-400');
                        if (iconI) iconI.classList.add('fa-check-circle');
                        break;
                    case 'cancelled':
                        statusLabel.classList.add('text-red-400');
                        if (iconBg) iconBg.classList.add('bg-red-500/10', 'text-red-400');
                        if (iconI) iconI.classList.add('fa-times-circle');
                        break;
                    default:
                        statusLabel.classList.add('text-slate-400');
                        if (iconBg) iconBg.classList.add('bg-slate-500/10', 'text-slate-400');
                        if (iconI) iconI.classList.add('fa-info-circle');
                }

                // Эффект пульсации при обновлении (без изменения бордеров, чтобы не дергать layout)
                orderBox.classList.add('bg-white/[0.08]');
                setTimeout(() => {
                    orderBox.classList.remove('bg-white/[0.08]');
                }, 500);
            });
    });
});
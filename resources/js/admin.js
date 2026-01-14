import './bootstrap';

window.Pusher.logToConsole = true;

document.addEventListener('DOMContentLoaded', () => {
    const ordersList = document.getElementById('orders-list');

    if (!ordersList) return;

    // Справочник названий статусов (соответствует Order::getStatuses())
    const statusLabels = {
        'new': 'Новый',
        'processing': 'В обработке',
        'done': 'Выполнен',
        'cancelled': 'Отменён',
    };

    // Справочник стилей (соответствует вашему Blade @php блоку)
    const statusStyles = {
        'new': 'bg-blue-600',
        'processing': 'bg-yellow-500 !text-black',
        'done': 'bg-green-600',
        'cancelled': 'bg-slate-700',
    };

    window.Echo.channel('orders')
        .listen('.OrderCreated', (e) => {
            console.log('Новый заказ получен!', e);

            // Удаляем сообщение "Заказов нет"
            const noOrdersMsg = ordersList.querySelector('p.text-center');
            if (noOrdersMsg) noOrdersMsg.remove();

            const row = document.createElement('div');
            // Применяем классы из Blade: glass-panel + остальные
            row.className = 'glass-panel rounded-2xl p-3 border-white/5 hover:border-white/10 transition-all opacity-0';
            row.style.transform = 'translateY(-10px)';
            row.style.transition = 'all 0.4s ease-out';

            const now = new Date();
            const dateStr = now.toLocaleDateString('ru-RU') + ' ' + 
                            now.toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' });

            // Форматируем цену
            const formattedPrice = new Intl.NumberFormat('ru-RU').format(e.total_price);

            // Генерируем HTML, идентичный структуре в Blade
            row.innerHTML = `
                <div class="flex flex-col gap-3">
                    
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <span class="font-display font-black text-accent text-sm italic">#${e.id}</span>
                            <h3 class="text-sm font-bold text-white uppercase truncate max-w-[140px]">${e.name}</h3>
                        </div>
                        <div class="px-2 py-0.5 rounded-md ${statusStyles[e.status] || 'bg-slate-500'} text-[8px] font-black uppercase tracking-wider shadow-sm">
                            ${statusLabels[e.status] || e.status}
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t border-white/5 pt-3">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-slate-400 font-mono">${e.phone}</span>
                            <span class="text-[8px] text-slate-600 font-bold uppercase">${dateStr}</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <span class="text-[11px] font-display font-black text-white italic">${formattedPrice} ₽</span>
                            </div>
                            <a href="/admin/orders/${e.id}" 
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 text-slate-400 hover:text-white transition-colors">
                                <i class="fas fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                </div>
            `;

            // Добавляем в начало списка
            ordersList.prepend(row);
            
            // Анимация появления
            requestAnimationFrame(() => {
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            });
        });
});
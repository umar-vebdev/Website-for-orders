import"./app-fbzhJThJ.js";window.Pusher.logToConsole=!0;document.addEventListener("DOMContentLoaded",()=>{const s=document.getElementById("orders-list");if(!s)return;const o={new:"Новый",processing:"В обработке",done:"Выполнен",cancelled:"Отменён"},r={new:"bg-blue-600",processing:"bg-yellow-500 !text-black",done:"bg-green-600",cancelled:"bg-slate-700"};window.Echo.channel("orders").listen(".OrderCreated",t=>{console.log("Новый заказ получен!",t);const a=s.querySelector("p.text-center");a&&a.remove();const e=document.createElement("div");e.className="glass-panel rounded-2xl p-3 border-white/5 hover:border-white/10 transition-all opacity-0",e.style.transform="translateY(-10px)",e.style.transition="all 0.4s ease-out";const n=new Date,l=n.toLocaleDateString("ru-RU")+" "+n.toLocaleTimeString("ru-RU",{hour:"2-digit",minute:"2-digit"}),i=new Intl.NumberFormat("ru-RU").format(t.total_price);e.innerHTML=`
                <div class="flex flex-col gap-3">
                    
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <span class="font-display font-black text-accent text-sm italic">#${t.id}</span>
                            <h3 class="text-sm font-bold text-white uppercase truncate max-w-[140px]">${t.name}</h3>
                        </div>
                        <div class="px-2 py-0.5 rounded-md ${r[t.status]||"bg-slate-500"} text-[8px] font-black uppercase tracking-wider shadow-sm">
                            ${o[t.status]||t.status}
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t border-white/5 pt-3">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-slate-400 font-mono">${t.phone}</span>
                            <span class="text-[8px] text-slate-600 font-bold uppercase">${l}</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <span class="text-[11px] font-display font-black text-white italic">${i} ₽</span>
                            </div>
                            <a href="/admin/orders/${t.id}" 
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 text-slate-400 hover:text-white transition-colors">
                                <i class="fas fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                </div>
            `,s.prepend(e),requestAnimationFrame(()=>{e.style.opacity="1",e.style.transform="translateY(0)"})})});

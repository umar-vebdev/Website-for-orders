<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class OrderExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $orders = Order::with('items.dish')->get();
        $data = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $data[] = [
                    'date' => $order->created_at->format('d.m.Y H:i'),
                    'dish_name' => $item->dish->name,
                    'quantity' => $item->quantity,
                    'total_price' => $item->price * $item->quantity,
                    'customer' => $order->name,
                ];
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        return ['Дата', 'Наименование товара', 'Количество', 'Стоимость', 'Заказчик'];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['client_id', 'name', 'phone', 'address', 'total_price', 'status'];

    public const STATUS_NEW = 'new';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_DONE = 'done';
    public const STATUS_CANCELLED = 'cancelled';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_PROCESSING => 'В обработке',
            self::STATUS_DONE => 'Выполнен',
            self::STATUS_CANCELLED => 'Отменён',
        ];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Cho phép lưu các cột này vào bảng bookings
    protected $fillable = [
        'user_id', 
        'tour_id', 
        'guests_count', 
        'total_price', 
        'status'
    ];

    // Mối quan hệ: 1 Đơn đặt tour thuộc về 1 Khách hàng (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mối quan hệ: 1 Đơn đặt tour thuộc về 1 Tour cụ thể
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}

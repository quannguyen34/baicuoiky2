<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'category_id', 
        'price', 
        'duration', 
        'start_date',  // <-- Đảm bảo dòng này có mặt ở đây
        'location', 
        'description', 
        'image'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}

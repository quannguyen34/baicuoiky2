<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Cho phép thêm dữ liệu vào các cột này
    protected $fillable = ['name', 'description'];

    // Khai báo mối quan hệ: 1 Danh mục sẽ có nhiều Tour du lịch (hasMany)
    public function tours()
    {
        return $this->hasMany(Tour::class);
    }
}

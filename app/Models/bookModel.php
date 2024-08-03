<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookModel extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters){
        if($filters['keyword'] ?? false){
        $query->where('bookName','like','%' . request('keyword') . '%');
        }
    }
}

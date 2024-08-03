<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pageModel extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters){
        if($filters['keyword'] ?? false){
        $query->where('title','like','%' . request('keyword') . '%')
        ->orWhere('pageNo', 'like', '%' . request('keyword') . '%');
        }
    }
}

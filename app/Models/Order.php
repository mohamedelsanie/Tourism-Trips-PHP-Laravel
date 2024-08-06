<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'amount',
        'fin_price',
        'tour_id',
        'tour_id',
        'offers',
        'from_date',
        'to_date',
        'from_place',
        'to_place',
        'invoice_id',
        'user_id',
        'status',
    ];
    protected $casts = [
        'offers' => 'array',
    ];

    public function user(){
        return $this->belongsTomany(User::class,'users');
    }

    public function tour(){
        return $this->belongsTo(Tour::class,'tour_id');
    }

    public function offers() {
        return $this->belongsTomany(Offer::class, 'offers');
    }
}

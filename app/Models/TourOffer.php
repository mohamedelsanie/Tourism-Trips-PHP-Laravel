<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourOffer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'tour_id','offer_id',
    ];

    public function offers()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactReply extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'comment',
        'contact_id',
        'admin_id',
    ];

    public function contact(){
        return $this->belongsTomany(Contact::class,'contacts');
    }

    public function admin(){
        return $this->belongsTomany(Admin::class,'admins');
    }
}

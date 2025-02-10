<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    //
    protected $table = 'services';
    protected $fillable = ['title', 'description', 'service_list'];

    // public function serviceList()
    // {
    //     return $this->belongsTo(ServicesList::class, 'service_list_id');
    // }
}

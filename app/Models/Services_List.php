<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services_List extends Model
{
    //
    protected $table = 'services__lists';
    protected $fillable = ['title'];

    public function services()
    {
        return $this->hasMany(Services::class, 'service_list_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id', 'number', 'is_business'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}

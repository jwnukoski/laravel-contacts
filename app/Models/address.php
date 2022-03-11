<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id', 'line_1', 'line_2', 'city', 'state', 'zip', 'is_business'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}

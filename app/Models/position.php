<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id', 'department_id', 'title', 'is_liason'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}

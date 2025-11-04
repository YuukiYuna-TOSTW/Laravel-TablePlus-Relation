<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    // pastikan nama tabel dan primary key default
    protected $table = 'experiences';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // mass assignment
    protected $guarded = [];

    // relasi ke About (about.experience_id)
    public function abouts()
    {
        return $this->hasMany(About::class, 'experience_id');
    }
}

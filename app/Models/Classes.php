<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function students(): HasMany
    {
<<<<<<< HEAD
        return $this->hasMany(Student::class, 'class_id');
    }

    public function getStudentsCountAttribute()
    {
        return $this->students()->count();
=======
        return $this->hasMany(Student::class);
>>>>>>> 2f929c2d7ac06be22b18a5a773c5226b634c29d9
    }
}

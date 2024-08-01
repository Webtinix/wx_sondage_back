<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Lang extends Model
{
    use  HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lib',
        'iso',
    ];

    public function attributeLangs(): HasMany
    {
        return $this->hasMany(AttributeLang::class);
    }

    public function dataLangs(): HasMany
    {
        return $this->hasMany(DataLang::class);
    }

    public function classLangs(): HasMany
    {
        return $this->hasMany(ClassLang::class);
    }
}

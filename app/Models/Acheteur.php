<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Acheteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'telephone',
    ];

    public function produits(): BelongsToMany
    {
        return $this->belongsToMany(Produit::class, 'achats')
                     ->withPivot('quantite', 'date_achat')
                     ->withTimestamps();
    }

    public function achats(): HasMany
    {
        return $this->hasMany(Achat::class);
    }
}
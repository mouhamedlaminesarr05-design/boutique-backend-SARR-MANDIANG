<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achat extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantite',
        'date_achat',
        'produit_id',
        'acheteur_id',
    ];

    protected $casts = [
        'date_achat' => 'date',
    ];

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public function acheteur(): BelongsTo
    {
        return $this->belongsTo(Acheteur::class);
    }
}
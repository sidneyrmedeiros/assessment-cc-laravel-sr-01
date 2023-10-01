<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Battle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int>
     */
    protected $fillable = [
        'monsterA',
        'monsterB',
        'winner',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the winner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function winner(): BelongsTo
    {
        return $this->belongsTo(Monster::class);
    }

    /**
     * Get the monsterA
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function monsterA(): BelongsTo
    {
        return $this->belongsTo(Monster::class);
    }

    /**
     * Get the monsterB
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function monsterB(): BelongsTo
    {
        return $this->belongsTo(Monster::class);
    }
}

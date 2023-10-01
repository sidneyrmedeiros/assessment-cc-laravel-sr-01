<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface BattleRepositoryInterface
{
    public function getAllBattles(): Collection;
}

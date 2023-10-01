<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface MonsterRepositoryInterface
{
    public function createMonster(array $newMonster): Model;

    public function updateMonster($monsterId, array $newMonster): void;

    public function removeMonster($monsterId): void;
}

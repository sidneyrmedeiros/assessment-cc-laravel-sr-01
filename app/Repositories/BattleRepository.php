<?php

namespace App\Repositories;

use App\Interfaces\BattleRepositoryInterface;
use App\Models\Battle;
use Illuminate\Support\Collection;

class BattleRepository implements BattleRepositoryInterface
{
    public function getAllBattles(): Collection
    {
        return Battle::with('winner')->with('monsterA')->with('monsterB')->get();
    }

    public function getBattleById($battleId): Battle
    {
        return Battle::with('winner')->with('monsterA')->with('monsterB')->find($battleId);
    }

    public function createBattle(array $newBattle): Battle
    {
        return Battle::create($newBattle);
    }

    public function removeBattle($battleId): void
    {
        Battle::destroy($battleId);
    }
}

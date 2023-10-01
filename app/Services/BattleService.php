<?php

namespace App\Services;

use App\Models\Battle;
use App\Models\Monster;
use App\Repositories\BattleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class BattleService
{
    /**
     * @var
     */
    protected $battleRepository;

    /**
     * BattleService constructor.
     *
     * @param  BattleRepository  $battleRepository
     */
    public function __construct(BattleRepository $battleRepository)
    {
        $this->battleRepository = $battleRepository;
    }

    /**
     * Get all battles.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->battleRepository->getAllBattles();
    }

    public function getBattleById($battleId): Battle
    {
        return $this->battleRepository->getBattleById($battleId);
    }

    /**
     * Create a battle.
     *
     * @param  mixed  $newBattle
     * @return Battle|JsonResponse
     */
    public function createBattle($newBattle): Battle|JsonResponse
    {
        $monsterA = Monster::find($newBattle['monsterA']);
        $monsterB = Monster::find($newBattle['monsterB']);
        $newBattle['winner'] = null;

        while (true) {
            if ($monsterA->speed > $monsterB->speed) {
                $damage = $monsterA->attack <= $monsterB->defense ? 1 : $monsterB->defense - $monsterA->attack;
                $monsterB->hp = $monsterB->hp - $damage;

                $damage = $monsterB->attack <= $monsterA->defense ? 1 : $monsterA->defense - $monsterB->attack;
                $monsterA->hp = $monsterA->hp - $damage;
            } elseif ($monsterB->speed > $monsterA->speed) {
                $damage = $monsterB->attack <= $monsterA->defense ? 1 : $monsterA->defense - $monsterB->attack;
                $monsterA->hp = $monsterA->hp - $damage;

                $damage = $monsterA->attack <= $monsterB->defense ? 1 : $monsterB->defense - $monsterA->attack;
                $monsterB->hp = $monsterB->hp - $damage;
            } else {
                if ($monsterA->attack > $monsterB->attack) {
                    $damage = $monsterA->attack <= $monsterB->defense ? 1 : $monsterB->defense - $monsterA->attack;
                    $monsterB->hp = $monsterB->hp - $damage;

                    $damage = $monsterB->attack <= $monsterA->defense ? 1 : $monsterA->defense - $monsterB->attack;
                    $monsterA->hp = $monsterA->hp - $damage;
                } else {
                    $damage = $monsterB->attack <= $monsterA->defense ? 1 : $monsterA->defense - $monsterB->attack;
                    $monsterA->hp = $monsterA->hp - $damage;

                    $damage = $monsterA->attack <= $monsterB->defense ? 1 : $monsterB->defense - $monsterA->attack;
                    $monsterB->hp = $monsterB->hp - $damage;
                }
            }

            if ($monsterA->hp <= 0) {
                $newBattle['winner'] = $monsterB->id;
            }
            if ($monsterB->hp <= 0) {
                $newBattle['winner'] = $monsterA->id;
            }
            if ($newBattle['winner']) {
                break;
            }
        }

        return $this->battleRepository->createBattle($newBattle);
    }

    /**
     * Remove a battle.
     *
     * @param  mixed  $battleId
     * @return void
     */
    public function removeBattle($battleId): void
    {
        $this->battleRepository->removeBattle($battleId);
    }
}

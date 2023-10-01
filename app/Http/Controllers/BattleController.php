<?php

namespace App\Http\Controllers;

use App\Services\BattleService;
use App\Services\MonsterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BattleController extends Controller
{
    /**
     * @var
     */
    protected $battleService;

    /**
     * @var
     */
    protected $monsterService;

    /**
     * BattleService constructor.
     *
     * @param  BattleService  $battleService
     * @param  MonsterService  $monsterService
     */
    public function __construct(BattleService $battleService, MonsterService $monsterService)
    {
        $this->battleService = $battleService;
        $this->monsterService = $monsterService;
    }

    /**
     * Get all battles.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            [
                'data' => $this->battleService->getAll(),
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Create new battle.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $newBattle = $request->only([
            'monsterA',
            'monsterB',
        ]);

        return response()->json(
            [
                'data' => $this->battleService->createBattle($newBattle),
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Remove a batte.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function remove(Request $request): JsonResponse
    {
        $battleId = $request->route('id');
        $result = $this->battleService->getBattleById($battleId);

        $this->battleService->removeBattle($battleId);

        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}

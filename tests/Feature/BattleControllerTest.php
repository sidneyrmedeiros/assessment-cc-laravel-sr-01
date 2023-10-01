<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class BattleControllerTest extends TestCase
{
    use RefreshDatabase;

    private $battle;

    private $monster1;

    private $monster2;

    private $monster3;

    private $monster4;

    private $monster5;

    private $monster6;

    private $monster7;

    public function setUp(): void
    {
        parent::setUp();
        $this->monster1 = $this->createMonsters([
            'name' => 'My monster Test',
            'attack' => 20,
            'defense' => 40,
            'hp' => 70,
            'speed' => 10,
            'imageUrl' => '',
        ]);

        $this->monster2 = $this->createMonsters([
            'name' => 'My monster Test 2',
            'attack' => 2,
            'defense' => 40,
            'hp' => 70,
            'speed' => 10,
            'imageUrl' => '',
        ]);

        $this->createBattles();
    }

    public function test_should_get_all_battles_correctly()
    {
        $this->createBattles();

        $response = $this->getJson('api/battles')->assertStatus(Response::HTTP_OK)->json('data');

        $this->assertEquals(2, count($response));
    }

    public function test_should_create_a_battle_with_a_bad_request_response_if_one_parameter_is_null()
    {
        // @TODO implement
    }

    public function test_should_create_a_battle_with_404_error_if_one_parameter_has_a_monster_id_does_not_exists()
    {
        // @TODO implement
    }

    public function test_should_create_battle_correctly_with_monsterA_winning()
    {
        //$monster = Monster::factory()->make();
        $response = $this->postJson('api/battles', [
            'monsterA' => $this->monster1->id,
            'monsterB' => $this->monster2->id,
        ])->assertStatus(Response::HTTP_CREATED)->json('data');

        $this->assertEquals($this->monster1->id, $response['winner']);
    }

    public function test_should_create_battle_correctly_with_monsterB_winning()
    {
        // @TODO implement
    }

    public function test_should_create_battle_correctly_with_monsterA_winning_if_theirs_speeds_same_and_monsterA_has_higher_attack()
    {
        // @TODO implement
    }

    public function test_should_create_battle_correctly_with_monsterB_winning_if_theirs_speeds_same_and_monsterB_has_higher_attack()
    {
        // @TODO implement
    }

    public function test_should_create_battle_correctly_with_monsterA_winning_if_theirs_defense_same_and_monsterA_has_higher_speed()
    {
        // @TODO implement
    }

    public function test_should_delete_a_battle_correctly()
    {
        $this->deleteJson('api/battles/1')->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_should_delete_with_404_error_if_battle_does_not_exists()
    {
        // @TODO implement
    }
}

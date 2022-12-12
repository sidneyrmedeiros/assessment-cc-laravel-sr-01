<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class BattleControllerTest extends TestCase
{
    use RefreshDatabase;

    private $battle, $monster1, $monster2, $monster3, $monster4, $monster5, $monster6, $monster7;

    public function setUp(): void
    {
        parent::setUp();
        $this->monster1 = $this->createMonsters([
            'name' => 'My monster Test 1',
            'attack' => 40,
            'defense' => 20,
            'hp' => 50,
            'speed' => 80,
            'imageUrl' => ''
        ]);
        $this->monster2 = $this->createMonsters([
            'name' => 'My monster Test 2',
            'attack' => 70,
            'defense' => 20,
            'hp' => 100,
            'speed' => 40,
            'imageUrl' => ''
        ]);
        $this->monster3 = $this->createMonsters([
            'name' => 'My monster Test 3',
            'attack' => 40,
            'defense' => 20,
            'hp' => 50,
            'speed' => 10,
            'imageUrl' => ''
        ]);
        $this->monster4 = $this->createMonsters([
            'name' => 'My monster Test 4',
            'attack' => 70,
            'defense' => 20,
            'hp' => 50,
            'speed' => 40,
            'imageUrl' => ''
        ]);
        $this->monster5 = $this->createMonsters([
            'name' => 'My monster Test 5',
            'attack' => 40,
            'defense' => 20,
            'hp' => 100,
            'speed' => 40,
            'imageUrl' => ''
        ]);
        $this->monster6 = $this->createMonsters([
            'name' => 'My monster Test 6',
            'attack' => 10,
            'defense' => 10,
            'hp' => 100,
            'speed' => 80,
            'imageUrl' => ''
        ]);
        $this->monster7 = $this->createMonsters([
            'name' => 'My monster Test 7',
            'attack' => 60,
            'defense' => 10,
            'hp' => 150,
            'speed' => 40,
            'imageUrl' => ''
        ]);
        $this->battle = $this->createBattles([
            'monsterA' => $this->monster1->id,
            'monsterB' => $this->monster2->id,
            'winner' => $this->monster1->id,
        ]);
    }

    public function test_should_get_all_battles_correctly()
    {
        $this->createBattles();

        $response = $this->getJson('api/battles')->assertStatus(Response::HTTP_OK)->json('data');
 
        $this->assertEquals(2, count($response));
    }

    public function test_should_create_a_battle_with_a_bad_request_response_if_one_parameter_is_null()
    {
        $response = $this->postJson('api/battles', [
            'monsterA' => null,
            'monsterB' => $this->monster2->id
        ])->assertStatus(Response::HTTP_BAD_REQUEST)->json();

        $this->assertEquals('Missing ID.', $response['message']);
    }

    public function test_should_create_a_battle_with_404_error_if_one_parameter_has_a_monster_id_does_not_exists()
    {
        $response = $this->postJson('api/battles', [
            'monsterA' => 999999,
            'monsterB' => $this->monster2->id
        ])->assertStatus(Response::HTTP_NOT_FOUND)->json();

        $this->assertEquals('Invalid ID.', $response['message']);
    }

    public function test_should_create_battle_correctly_with_monsterA_winning()
    {
        $response = $this->postJson('api/battles', [
            'monsterA' => $this->monster1->id,
            'monsterB' => $this->monster2->id
        ])->assertStatus(Response::HTTP_OK)->json('data');

        $this->assertEquals($this->monster1->id, $response['id']);
    }

    public function test_should_create_battle_correctly_with_monsterB_winning()
    {
        $response = $this->postJson('api/battles', [
            'monsterA' => $this->monster3->id,
            'monsterB' => $this->monster2->id
        ])->assertStatus(Response::HTTP_OK)->json('data');

        $this->assertEquals($this->monster2->id, $response['id']);
    }

    public function test_should_create_battle_correctly_with_monsterA_winning_if_theirs_speeds_same_and_monsterA_has_higher_attack()
    {
        $response = $this->postJson('api/battles', [
            'monsterA' => $this->monster4->id,
            'monsterB' => $this->monster5->id
        ])->assertStatus(Response::HTTP_OK)->json('data');

        $this->assertEquals($this->monster4->id, $response['id']);
    }

    public function test_should_create_battle_correctly_with_monsterB_winning_if_theirs_speeds_same_and_monsterB_has_higher_attack()
    {
        $response = $this->postJson('api/battles', [
            'monsterA' => $this->monster5->id,
            'monsterB' => $this->monster7->id
        ])->assertStatus(Response::HTTP_OK)->json('data');

        $this->assertEquals($this->monster7->id, $response['id']);
    }

    public function test_should_create_battle_correctly_with_monsterA_winning_if_theirs_defense_same_and_monsterA_has_higher_speed()
    {
        $response = $this->postJson('api/battles', [
            'monsterA' => $this->monster6->id,
            'monsterB' => $this->monster7->id
        ])->assertStatus(Response::HTTP_OK)->json('data');

        $this->assertEquals($this->monster6->id, $response['id']);
    }

    public function test_should_delete_a_battle_correctly()
    {
        $this->deleteJson('api/battles/1')->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_should_delete_with_404_error_if_battle_does_not_exists()
    {
        $response = $this->deleteJson('api/battles/999999')->assertStatus(Response::HTTP_NOT_FOUND)->json();

        $this->assertEquals('The battle does not exists.', $response['message']);
    }
}
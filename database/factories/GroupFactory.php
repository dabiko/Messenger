<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
//            'owner_id' => $this->faker->randomNumber(),
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//            'last_message_id' => $this->faker->randomNumber(),
        ];
    }
}

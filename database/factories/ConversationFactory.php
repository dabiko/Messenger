<?php

namespace Database\Factories;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ConversationFactory extends Factory
{
    protected $model = Conversation::class;

    public function definition(): array
    {
        return [
//            'user_id1' => $this->faker->randomNumber(),
//            'user_id2' => $this->faker->randomNumber(),
//            'last_message_id' => $this->faker->randomNumber(),
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
        ];
    }
}

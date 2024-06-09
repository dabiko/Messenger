<?php

namespace Database\Factories;

use App\Models\MessageAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MessageAttachmentFactory extends Factory
{
    protected $model = MessageAttachment::class;

    public function definition(): array
    {
        return [
//            'message_id' => $this->faker->randomNumber(),
//            'name' => $this->faker->name(),
//            'path' => $this->faker->word(),
//            'size' => $this->faker->randomNumber(),
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
        ];
    }
}

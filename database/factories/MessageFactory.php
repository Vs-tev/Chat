<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
      
        return [
            'message' =>$this->faker->sentence,
            'is_seen' => 0,
            'user_id' => $this->faker->randomElement([3, 13]),
            'conversation_id' => 1,
        ];
        
    }
}
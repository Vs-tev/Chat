<?php

namespace Database\Factories;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conversation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do{
            $user_one = rand(1, 14);
            $user_two = rand(1, 14);
        }while ($user_one === $user_two);

        return [
            'user_one' => $user_one,
            'user_two' => $user_two,
            'status' => 0
        ];
    }
}

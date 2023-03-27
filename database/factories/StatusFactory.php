<?php

namespace Database\Factories;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Status::class;

    private $counter = 0;

    public function definition(): array
    {       
        $names = [
            'available', 'borrowed', 'processing'
        ];

        $name = $names[$this->counter];

        $this->counter++;
        
        return [
            'name' => $name,
        ];
    }
}

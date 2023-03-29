<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Role::class;

    private $counter = 0;

    public function definition(): array
    {       
        $names = [
            'Client', 'Receptionist', 'Admin'
        ];
        
        $name = $names[$this->counter];

        $this->counter++;
        
        return [
            'name' => $name,
        ];
    }
}

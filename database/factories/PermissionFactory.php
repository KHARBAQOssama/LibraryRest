<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Permission::class;

    private $counter = 0;
    
    public function definition(): array
    {
        $names = [
            'changeRoles', 'changePermissions', 'addBooks', 'updateBooks', 'deleteBooks',
            'addGender', 'updateGender', 'deleteGender', 'addComment', 'deleteComment', 'updateComment',
            'blockUser'
        ];
        $name = $names[$this->counter];

        $this->counter++;


        return [
            'name' => $name,
        ];
    }
}

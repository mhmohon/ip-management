<?php

namespace Database\Factories;

use App\Models\IPAddress;
use App\Traits\IPAddressTrait;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class IPAddressFactory extends Factory
{
    use IPAddressTrait;
    
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = IPAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label'         => fake()->sentence(2),
            'ip_address'    => $this->convertToBinary(fake()->ipv4()),
        ];
    }
}

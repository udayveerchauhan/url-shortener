<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShortUrl>
 */
class ShortUrlFactory extends Factory
{
    protected $model = ShortUrl::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'user_id' => User::factory(),
            'original_url' => fake()->url(),
            'short_code' => Str::lower(fake()->unique()->lexify('???????')),
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (ShortUrl $shortUrl) {
            if (! $shortUrl->company_id) {
                return;
            }

            if (! $shortUrl->user_id) {
                $shortUrl->user_id = User::factory()->create([
                    'company_id' => $shortUrl->company_id,
                ])->id;
            }
        });
    }
}

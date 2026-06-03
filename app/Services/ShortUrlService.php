<?php

namespace App\Services;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Support\Str;
use InvalidArgumentException;
use GuzzleHttp\Client;

class ShortUrlService
{
    public function generateCode(): string
    {
        do {
            $code = Str::random(6);
        } while (ShortUrl::where('short_code', $code)->exists());

        return $code;
    }

    public function createShortUrl(User $user, string $originalUrl): ShortUrl
    {
        if (! $user->company_id) {
            throw new InvalidArgumentException('User must belong to a company to create short URLs.');
        }

        return ShortUrl::create([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'original_url' => $originalUrl,
            'short_code' => $this->generateCode(),
        ]);
    }
}

<?php

namespace App\Services;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Support\Str;
use InvalidArgumentException;
use GuzzleHttp\Client;

class ShortUrlService
{
    public function generateCode(string $originalUrl): string
    {
        try {
            $client = new Client();
            // dd('Bearer ' . env('BITLY_API_KEY'));
            $response = $client->post(
                'https://api-ssl.bitly.com/v4/shorten',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('BITLY_API_KEY'),
                        'Content-Type'  => 'application/json',
                    ],
                    'json' => [
                        'long_url' => $originalUrl,
                    ],
                ]
            );

            $result = json_decode($response->getBody(), true);
            // dd($result);
            return $result['link'];
        } catch (\Exception $e) {
            \Log::info('Getting issue when generating short URL for ' . $originalUrl . ' at ' . now());
            throw new \Exception($e->getMessage());
        }
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
            'short_code' => $this->generateCode($originalUrl),
        ]);
    }
}

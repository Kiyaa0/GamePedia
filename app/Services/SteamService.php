<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SteamService
{
    public function __construct(
        protected string $apiKey,
    ) {}

    public function getCurrentPlayers(?int $appId): ?int
    {
        if ($appId === null) {
            return null;
        }

        return Cache::remember("steam_player_count_{$appId}", 300, function () use ($appId) {
            try {
                $response = Http::timeout(5)
                    ->connectTimeout(3)
                    ->get('https://api.steampowered.com/ISteamUserStats/GetNumberOfCurrentPlayers/v1/', [
                        'appid' => $appId,
                        'key' => $this->apiKey,
                    ]);

                if ($response->failed()) {
                    return null;
                }

                $body = $response->json();

                if (($body['response']['result'] ?? 0) !== 1) {
                    return null;
                }

                return $body['response']['player_count'] ?? null;
            } catch (ConnectionException) {
                return null;
            }
        });
    }

    public function getNewsForApp(?int $appId, int $count = 5, int $maxLength = 300): ?array
    {
        if ($appId === null) {
            return null;
        }

        return Cache::remember("steam_news_{$appId}_{$count}", 1800, function () use ($appId, $count, $maxLength) {
            try {
                $response = Http::timeout(5)
                    ->connectTimeout(3)
                    ->get('https://api.steampowered.com/ISteamNews/GetNewsForApp/v2/', [
                        'appid' => $appId,
                        'count' => $count,
                        'maxlength' => $maxLength,
                        'key' => $this->apiKey,
                    ]);

                if ($response->failed()) {
                    return null;
                }

                $body = $response->json();

                return $body['appnews']['newsitems'] ?? null;
            } catch (ConnectionException) {
                return null;
            }
        });
    }

    public function getAppDetails(?int $appId): ?array
    {
        if ($appId === null) {
            return null;
        }

        return Cache::remember("steam_app_details_{$appId}", 3600, function () use ($appId) {
            try {
                $response = Http::timeout(5)
                    ->connectTimeout(3)
                    ->get('https://store.steampowered.com/api/appdetails', [
                        'appids' => $appId,
                    ]);

                if ($response->failed()) {
                    return null;
                }

                $body = $response->json();

                if (! isset($body[$appId]['success']) || ! $body[$appId]['success']) {
                    return null;
                }

                return $body[$appId]['data'] ?? null;
            } catch (ConnectionException) {
                return null;
            }
        });
    }
}

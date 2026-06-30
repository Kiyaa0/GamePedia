<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RawgService
{
    public function __construct(
        protected string $baseUrl,
        protected string $apiKey,
    ) {}

    public function getGames(array $params = []): array
    {
        $cacheKey = 'rawg_games_'.md5(serialize($params));

        return Cache::remember($cacheKey, 3600, function () use ($params) {
            $response = $this->request()->get("{$this->baseUrl}/games", array_merge(
                [
                    'key' => $this->apiKey,
                    'page_size' => 20,
                    'exclude_additions' => true,
                    'esrb_rating' => 'everyone,everyone-10-plus,teen',
                ],
                $params
            ));

            return $response->json();
        });
    }

    public function getSafeGames(array $params = []): array
    {
        $excludeTagIds = [
            44,       // nudity
            50,       // Sexual Content
            785,      // Erotic
            890,      // eroge
            1081,     // adult
            4115,     // erotic-horror
            5946,     // sexuality
            7810,     // adult-game
            8168,     // sexual
            25505,    // sexual-content-2
            35931,    // adult-content
            35970,    // erotica
            37174,    // for-adults-only
            39233,    // adult-games
            39389,    // sexual-themes
            40489,    // adult-adventure
            41087,    // adult-visual-novel
            41628,    // 3d-adult-game
            41629,    // free-adult-game
            45121,    // adult-themes
            47199,    // erotic-games
            52640,    // adult-orientated
            53849,    // adult-rpg
            60009,    // partial-nudity
        ];

        $pageSize = $params['page_size'] ?? 20;
        $params['page_size'] = $pageSize;

        $data = $this->getGames($params);

        if (! isset($data['results'])) {
            return $data;
        }

        $filtered = [];
        foreach ($data['results'] as $game) {
            $gameTags = collect($game['tags'] ?? []);
            $hasAdultTag = $gameTags->pluck('id')->intersect($excludeTagIds)->isNotEmpty();

            if (! $hasAdultTag) {
                $filtered[] = $game;
            }
        }

        $data['results'] = $filtered;
        $data['count'] = count($filtered);

        return $data;
    }

    public function getGame(string $id): ?array
    {
        $cacheKey = 'rawg_game_'.$id;

        return Cache::remember($cacheKey, 3600, function () use ($id) {
            $response = $this->request()->get("{$this->baseUrl}/games/{$id}", [
                'key' => $this->apiKey,
            ]);

            if ($response->notFound()) {
                return null;
            }

            $response->throw();

            return $response->json();
        });
    }

    public function getScreenshots(string $id): array
    {
        $cacheKey = 'rawg_screenshots_'.$id;

        return Cache::remember($cacheKey, 3600, function () use ($id) {
            $response = $this->request()->get("{$this->baseUrl}/games/{$id}/screenshots", [
                'key' => $this->apiKey,
            ]);

            if ($response->notFound()) {
                return [];
            }

            $response->throw();

            return $response->successful() ? ($response->json()['results'] ?? []) : [];
        });
    }

    public function getGenres(): array
    {
        return Cache::remember('rawg_genres', 86400, function () {
            $response = $this->request()->get("{$this->baseUrl}/genres", [
                'key' => $this->apiKey,
            ]);

            return $response->successful() ? ($response->json()['results'] ?? []) : [];
        });
    }

    protected function request(): PendingRequest
    {
        return Http::timeout(7)
            ->connectTimeout(5)
            ->retry(1, 500, function (ConnectionException|RequestException $exception, PendingRequest $request) {
                return $exception instanceof ConnectionException
                    || ($exception instanceof RequestException && $exception->response->serverError());
            })
            ->acceptJson();
    }
}

<?php

namespace TheAgency2627\SocialiteLauncher;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;

class LauncherProvider extends AbstractProvider
{
    protected $usesPKCE = true;

    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase(config('services.launcher.url') . '/oauth/authorize', $state);
    }

    protected function getTokenUrl(): string
    {
        return config('services.launcher.url') . '/oauth/token';
    }

    protected function getUserByToken($token): array
    {
        $response = $this->getHttpClient()->get(config('services.launcher.url') . '/api/user', [
            'headers' => ['Authorization' => "Bearer {$token}", 'Accept' => 'application/json'],
        ]);

        return json_decode($response->getBody(), true)['data'];
    }

    protected function mapUserToObject(array $user): User
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['id'],
            'name' => "{$user['first_name']} {$user['last_name']}",
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'avatar' => $user['avatar_url'],
        ]);
    }
}

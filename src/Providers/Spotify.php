<?php

namespace Datlechin\OAuthSpotify\Providers;

use Flarum\Forum\Auth\Registration;
use FoF\OAuth\Provider;
use Illuminate\Support\Arr;
use League\OAuth2\Client\Provider\AbstractProvider;

class Spotify extends Provider
{
    public function name(): string
    {
        return 'spotify';
    }

    public function link(): string
    {
        return 'https://developer.spotify.com/dashboard';
    }

    public function fields(): array
    {
        return [
            'client_id' => ['required', 'string'],
            'client_secret' => ['required', 'string'],
        ];
    }

    public function provider(string $redirectUri): AbstractProvider
    {
        return new SpotifyProvider([
            'clientId' => $this->getSetting('client_id'),
            'clientSecret' => $this->getSetting('client_secret'),
            'redirectUri' => $redirectUri,
        ]);
    }

    /**
     * @param  SpotifyResourceOwner  $user
     */
    public function suggestions(Registration $registration, $user, string $token): void
    {
        $registration
            ->provideTrustedEmail($user->getEmail())
            ->suggestUsername($user->getDisplayName());

        if ($avatarUrl = Arr::get($user->getImages(), '0.url')) {
            $registration->provideAvatar($avatarUrl);
        }

        $registration->setPayload($user->toArray());
    }
}

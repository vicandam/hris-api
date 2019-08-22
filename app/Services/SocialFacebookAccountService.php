<?php

namespace App\Services;
use App\SocialFacebookAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialFacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $data = [
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1,10000)),
                    'slug' => str_slug($providerUser->getName(), '-'),
                    'photo' => $providerUser->getAvatar(),
                    'fb_id' => $providerUser->getId(),
                ];

                $user = User::create($data);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        } else {
            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $data = [
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1,10000)),
                    'slug' => str_slug($providerUser->getName(), '-'),
                    'photo' => $providerUser->getAvatar(),
                    'fb_id' => $providerUser->getId(),
                ];

                $user = User::create($data);
           }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}
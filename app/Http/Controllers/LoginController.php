<?php

namespace BandManager\App\Http\Controllers;

use BandManager\App\Api\Facebook;
use BandManager\App\Models\User;
use BandManager\Routing\ViewController;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends ViewController
{
    public function __construct(
        private readonly Facebook $facebook,
        private readonly AuthManager $authManager,
    ) {}

    public function handleFacebookLogin(Request $request): Response
    {
        $result = $this->facebook->handleAuth($request);

        if (array_key_exists('error', $result)) {
            return $this->render('part.facebook-login-result', [
                'reason' => $result['error']['message'] ?? null,
            ]);
        }

        if ($user = $this->getOrCreateFacebookUser($result['id'], $result['name'])) {
            $this->authManager->login($user);

            return $this->render('part.facebook-login-result', [
                'success' => true,
            ]);
        }

        return $this->render('part.facebook-login-result', [
            'reason' => 'Neregistrovaný uživatel.',
        ]);
    }

    private function getOrCreateFacebookUser(string $facebookId, string $displayName): ?User
    {
        $existing = User::query()
            ->where('fb_id', '=', $facebookId)
            ->take(1)
            ->get();

        if (count($existing) === 1) {
            return $existing[0];
        }

        $user = new User([
            'fb_id' => $facebookId,
            'display_name' => $displayName,
        ]);
        $user->save();

        return $user;
    }
}

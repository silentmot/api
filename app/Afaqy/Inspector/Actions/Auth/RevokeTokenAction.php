<?php

namespace Afaqy\Inspector\Actions\Auth;

use Afaqy\Core\Actions\Action;
use Illuminate\Support\Facades\Auth;

class RevokeTokenAction extends Action
{
    /**
     * @return mixed
     */
    public function execute()
    {
        $tokens = Auth::user()->tokens ?? [];

        foreach ($tokens as $token) {
            $token->revoke();
        }

        return true;
    }
}

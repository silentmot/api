<?php

namespace Afaqy\User\Listeners;

class RevokeUserTokens
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $tokens = $event->user->tokens;

        foreach ($tokens as $token) {
            $token->revoke();
        }
    }
}

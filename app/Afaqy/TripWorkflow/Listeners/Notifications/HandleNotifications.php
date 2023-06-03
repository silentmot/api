<?php

namespace Afaqy\TripWorkflow\Listeners\Notifications;

use Afaqy\Role\Models\Notification;
use Illuminate\Support\Facades\Mail;
use Afaqy\Dashboard\Models\Dashboard;

trait HandleNotifications
{
    /**
     * @param  object $event
     * @param  string $mail
     * @return boolean
     */
    public function sendNotification($event, $mail)
    {
        $notification = Notification::where('name', (new \ReflectionClass($event))->getShortName())->first();

        if (!$notification) {
            return true;
        }

        $roles = $notification->roles()->get();

        if ($roles->isEmpty()) {
            return true;
        }

        $trip = Dashboard::find($event->data->id);

        foreach ($roles as $role) {
            $users = $role->users()->get();

            if ($users->isEmpty()) {
                continue;
            }

            foreach ($users as $user) {
                $event_name = (new \ReflectionClass($event))->getShortName();

                Mail::to($user)->send(new $mail($trip, $user, $event_name));
            }
        }

        return true;
    }
}

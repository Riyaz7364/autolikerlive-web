<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/*
|--------------------------------------------------------------------------
| Temp Mail push channels
|--------------------------------------------------------------------------
|
| The websocket "user" here is irrelevant — what matters is that the
| inbox token embedded in the channel name still belongs to a live
| (unexpired) inbox. That token is the secret of the app instance that
| created the mailbox, and the authorization endpoint itself requires
| a valid X-Firebase-AppCheck header.
|
*/
Broadcast::channel('inbox.{inboxToken}', function ($user, string $inboxToken) {
    $inbox = \App\Models\TempInbox::where('inbox_token', $inboxToken)->first();

    return $inbox !== null && $inbox->isActive();
});

<?php

namespace App\Utils;

use App\Models\User;
use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class FilamentUtil
{
    public static function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        if (!$user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }
        return $user;
    }

    public static function sendNotifToAdmin(string $url, string $title, ?string $body): void
    {
        Notification::make()
            ->title($title)
            ->body($body)
            ->info()
            ->actions([
                Action::make('View')->url($url)->button(),
            ])
            ->sendToDatabase(User::all());
    }
}

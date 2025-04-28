<?php

namespace App\Utils;

use App\Models\Company\Company;
use App\Models\Seeker\Seeker;
use App\Models\User;
use Exception;
use Filament\Notifications\Actions\Action;
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

    public static function isAdmin(): bool
    {
        return Filament::auth()->name === 'web';
    }

    public static function isContent(): bool
    {
        return Filament::auth()->name === 'content';
    }

    public static function sendNotifToAdmin(string $url, string $title, ?string $body): void
    {
        Notification::make()
            ->title($title)
            ->body($body)
            ->info()
            ->actions([
                Action::make('View')->url($url)->button()->markAsRead(),
            ])
            ->sendToDatabase(User::all());
    }

    public static function sendNotifToCompany(string $url, string $title, ?string $body, int $companyId): void
    {
        Notification::make()
            ->title($title)
            ->body($body)
            ->info()
            ->actions([
                Action::make('View')->url($url)->button()->markAsRead(),
            ])
            ->sendToDatabase(Company::find($companyId));
    }

    public static function sendNotifToSeeker(string $url, string $title, ?string $body, int $seekerId): void
    {
        Notification::make()
            ->title($title)
            ->body($body)
            ->info()
            ->actions([
                Action::make('View')->url($url)->button()->markAsRead(),
            ])
            ->sendToDatabase(Seeker::find($seekerId));
    }
}

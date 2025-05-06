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
use Illuminate\Support\Facades\Notification as NotificationFacade;
use App\Notifications\BaseNotification;

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

    public static function sendNotifToAdmin(
        string $url,
        string $title,
        ?string $body,
        bool $sendEmail = false,
    ): void {
        $users = User::all();

        Notification::make()
            ->title($title)
            ->body($body)
            ->info()
            ->actions([
                Action::make('View')->url($url)->button()->markAsRead(),
            ])
            ->sendToDatabase($users);

        if ($sendEmail) {
            foreach ($users as $user) {
                $user->notify(new BaseNotification(
                    title: $title,
                    body: $body,
                    url: $url
                ));
            }
        }
    }


    public static function sendNotifToCompany(
        string $url,
        string $title,
        ?string $body,
        int $companyId,
        bool $sendEmail = false
    ): void {
        $company = Company::find($companyId);

        if (!$company) {
            return;
        }

        Notification::make()
            ->title($title)
            ->body($body)
            ->info()
            ->actions([
                Action::make('View')->url($url)->button()->markAsRead(),
            ])
            ->sendToDatabase($company);

        if ($sendEmail && $company->email) {
            NotificationFacade::route('mail', $company->email)
                ->notify(new BaseNotification($title, $body, $url));
        }
    }

    public static function sendNotifToSeeker(
        string $url,
        string $title,
        ?string $body,
        int $seekerId,
        bool $sendEmail = false
    ): void {
        $seeker = Seeker::find($seekerId);

        if (!$seeker) {
            return;
        }

        Notification::make()
            ->title($title)
            ->body($body)
            ->info()
            ->actions([
                Action::make('View')->url($url)->button()->markAsRead(),
            ])
            ->sendToDatabase($seeker);

        if ($sendEmail && $seeker->email) {
            NotificationFacade::route('mail', $seeker->email)
                ->notify(new BaseNotification($title, $body, $url));
        }
    }

    public static function seekerAccepted(
        string $title,
        ?string $body,
        int $seekerId,
        int $companyId,
        bool $sendEmail = false
    ): void {
        $seeker = Seeker::find($seekerId);

        if (!$seeker) {
            return;
        }

        $seeker->update(['company_id' => $companyId]);

        Notification::make()
            ->success()
            ->title($title)
            ->body($body)
            ->sendToDatabase(Seeker::find($seekerId));

        if ($sendEmail && $seeker->email) {
            NotificationFacade::route('mail', $seeker->email)
                ->notify(new BaseNotification($title, $body, ""));
        }
    }
}

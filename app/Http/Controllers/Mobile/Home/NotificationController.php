<?php

namespace App\Http\Controllers\Mobile\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    public function index(): Response
    {
        $user = auth('seeker')->user();
        $notifications = collect($user->notifications)->map(fn($n) => ['created_at' => $n->created_at, 'read_at' => $n->read_at, ...$n->data]);
        return Inertia::render('Mobile/Home/Notification', [
            'notifications' => $notifications
        ]);
    }

    public function count()
    {
        $user = auth('seeker')->user();
        return response()->json(['total' => $user->unreadNotifications->count()]);
    }
}

<?php

namespace App\Http\Controllers\Berita;

use App\Filament\Resources\NewsResource;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

use App\Http\Controllers\Controller;
use App\Models\NewsComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = $request->except('_token');

        if (NewsComment::create($data)) {
            Notification::make()->title('There is a new comment')
                ->body('There is a new comment from ' . $request->name)
                ->info()
                ->actions([
                    Action::make('View')->url(NewsResource::getUrl('edit', ['record' => $request->news_id]))->button(),
                ])
                ->sendToDatabase(User::all());
            return redirect()->back()->with('success', 'Success Input Komentar');
        }
        return redirect()->back()->with('error', 'Error Input Komentar');
    }
}

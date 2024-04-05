<?php

namespace App\Http\Controllers\News;

use App\Filament\Admin\Resources\NewsResource;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use App\Http\Controllers\Controller;
use App\Models\Admin\News\NewsComment;
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
                    Action::make('View')
                        ->url(NewsResource::getUrl('comments', ['record' => $request->news_id, 'tableSearch' => $request->name]))
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase(User::all());
            return redirect()->back()->with('success', 'Success Input Komentar');
        }
        return redirect()->back()->with('error', 'Error Input Komentar');
    }
}

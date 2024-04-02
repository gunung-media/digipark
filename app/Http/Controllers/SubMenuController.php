<?php

namespace App\Http\Controllers;

use App\Models\Admin\Menu\SubMenu;
use Illuminate\Http\Request;

class SubMenuController extends Controller
{
    public function __invoke(Request $request, $slug)
    {
        $subMenu = SubMenu::where('slug', $slug)->firstOrFail();

        return view('portal.sub-menu', [
            'subMenu' => $subMenu
        ]);
    }
}

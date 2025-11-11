<?php

namespace App\View\Components\Site;

use App\Models\App\Cms\Menu;
use App\Models\App\Cms\MenuPosition;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderMobileMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        $menuPosition = MenuPosition::where('name', 'Main Menu')->first();

        if (!$menuPosition) {
            abort(404, 'Main Menu position not found');
        }

        // Fetch menus with their parent-child relationship
        $viewBag['mobileMenus'] = Menu::with(['parent', 'children' => function ($query) use ($menuPosition) {
                $query->where('menu_position_id', $menuPosition->id);
            }])
            ->active()
            ->whereNull('parent_id')
            ->where('menu_position_id', $menuPosition->id)
            ->orderBy('display_order', 'asc')
            ->get(['id', 'parent_id', 'title', 'url', 'open_in_newtab']);

        return view('components.site.header-mobile-menu', $viewBag);
    }

}

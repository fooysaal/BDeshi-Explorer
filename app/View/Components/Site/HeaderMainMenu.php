<?php

namespace App\View\Components\Site;

use App\Models\App\Cms\Menu;
use App\Models\App\Cms\MenuPosition;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderMainMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    // public function render(): View|Closure|string
    // {
	// 	$menuPositionId = MenuPosition::where('name', 'Main Menu')->first()->id;
	// 	$viewBag['menus'] = Menu::with('children:id,parent_id,title,url,open_in_newtab')
    //     ->active()
    //     ->WhereNull('parent_id')->where('menu_position_id', $menuPositionId)
    //     ->orderBy('display_order', 'asc')
    //     ->get(['id', 'title', 'url', 'open_in_newtab']);
	// 	return view('components.site.header-main-menu', $viewBag);
	// }
    // public function render(): View|Closure|string
    // {
    //     // Find the correct menu position for "Main Menu"
    //     $menuPosition = MenuPosition::where('name', 'Main Menu')->first();

    //     if (!$menuPosition) {
    //         abort(404, 'Main Menu position not found');
    //     }

    //     // Fetch only menus belonging to "Main Menu"
    //     $viewBag['menus'] = Menu::with(['children' => function ($query) use ($menuPosition) {
    //             $query->where('menu_position_id', $menuPosition->id); // Ensure children also belong to Main Menu
    //         }])
    //         ->active()
    //         ->whereNull('parent_id')
    //         ->where('menu_position_id', $menuPosition->id) // Ensure correct menu position
    //         ->orderBy('display_order', 'asc')
    //         ->get(['id', 'title', 'url', 'open_in_newtab']);

    //     return view('components.site.header-main-menu', $viewBag);
    // }

    public function render(): View|Closure|string
    {
        $menuPosition = MenuPosition::where('name', 'Main Menu')->first();

        if (!$menuPosition) {
            abort(404, 'Main Menu position not found');
        }

        // Fetch menus with their parent-child relationship
        $viewBag['menus'] = Menu::with(['parent', 'children' => function ($query) use ($menuPosition) {
                $query->where('menu_position_id', $menuPosition->id);
            }])
            ->active()
            ->whereNull('parent_id')
            ->where('menu_position_id', $menuPosition->id)
            ->orderBy('display_order', 'asc')
            ->get(['id', 'parent_id', 'title', 'url', 'open_in_newtab']);

        return view('components.site.header-main-menu', $viewBag);
    }

}

<?php

namespace App\View\Components\Site;

use App\Models\App\Cms\Page;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $page = Page::active()
            ->where('slug', getUrlLastSegment())
            ->first(['title', 'banner_image']);
    
        $viewBag['pageTitle'] = $page?->title;
        $viewBag['bannerImage'] = $page?->banner_image; // Ensure it's available
    
        return view('components.site.breadcrumbs', $viewBag);
    }
    // public function render()
    // {
    //     $viewBag['pageTitle'] = Page::active()
    //             ->where('slug', getUrlLastSegment())
    //             ->first()?->title;

    //     return view('components.site.breadcrumbs', $viewBag);
    // }
    
}

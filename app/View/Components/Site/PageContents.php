<?php

namespace App\View\Components\Site;

use App\Models\App\Cms\Page;
use Illuminate\View\Component;

class PageContents extends Component
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
    // public function render()
    // {
    //     $viewBag['pageContents'] = Page::active()
    //             ->where('slug', getUrlLastSegment())
    //             ->get(['title', 'contents', 'featured_image']);

    //     return view('components.site.page-contents', $viewBag);
    // }
    public function render()
    {
        $slug = getUrlLastSegment() ?: 'home-page'; // Default to home-page if empty

        $viewBag['pageContents'] = Page::active()
            ->where('slug', $slug)
            ->get(['title', 'contents', 'featured_image','banner_image']);

        return view('components.site.page-contents', $viewBag);
    }
    
}

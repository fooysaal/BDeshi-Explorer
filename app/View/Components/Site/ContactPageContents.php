<?php

namespace App\View\Components\Site;

use App\Models\App\Cms\Page;
use Illuminate\View\Component;

class ContactPageContents extends Component
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
        $viewBag['contactPageContents'] = Page::active()
                ->where('slug', getUrlLastSegment())
                ->get(['title', 'contents','excerpt', 'featured_image']);

        return view('components.site.contact-page-contents', $viewBag);
    }
    
}

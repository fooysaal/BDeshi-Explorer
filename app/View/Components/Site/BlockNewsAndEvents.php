<?php

namespace App\View\Components\Site;

use Illuminate\View\Component;

//class Testimonial extends Component
class BlockNewsAndEvents extends Component
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
        $viewBag['newsAndEvents'] = getPostsByCategories(['News & Event']);

        return view('components.site.block-news-and-events', $viewBag);
    }
}

<?php

namespace App\View\Components\Site;

use App\Models\App\Cms\Gallery;
use App\Models\App\Cms\GalleryImage;
use Illuminate\View\Component;

class HomeSlider extends Component
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
        $gallery = Gallery::active()->where('name', 'Home Slider')->first();
        $viewBag['images'] = GalleryImage::ascending('display_order')
        ->active()
        ->where('galleries_id', $gallery->id ?? '')
        ->get(['image', 'title', 'description']);

        return view('components.site.home-slider', $viewBag);
    }
}

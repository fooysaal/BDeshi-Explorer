<?php

namespace App\View\Components\Site;

use App\Models\App\Cms\Testimonial;
use Illuminate\View\Component;

//class Testimonial extends Component
class HomeTestimonials extends Component
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
        $viewBag['testimonials'] = Testimonial::active()->orderBy('created_at', 'desc')->get();
        return view('components.site.home-testimonials', $viewBag);
    }
}

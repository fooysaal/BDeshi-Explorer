<?php

namespace App\View\Components\Site;

use Illuminate\View\Component;
use App\Models\App\Inventory\Shop;

class ShopPageContents extends Component
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
	//     $slug = getUrlLastSegment() ?: 'home-page'; // Default to home-page if empty

	//     $viewBag['propertyPageContents'] = Page::active()
	//         ->where('slug', $slug)
	//         ->get(['title', 'contents', 'featured_image','banner_image', 'created_at']);

	//     return view('components.site.property-page-contents', $viewBag);
	// }

	public function render()
	{
		$slug = getUrlLastSegment() ?: 'home-page'; // Default to home-page if empty

		if ($slug == 'shop') {
			$shops = Shop::orderBy('id', 'desc')->where('status', 'active')->get();
			$viewBag['shops'] = $shops;
		} else {
			abort(404);
		}

		return view('components.site.shop-page-contents', $viewBag);
	}
}

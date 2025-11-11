<?php

namespace App\View\Components\Site;

use Closure;
use GuzzleHttp\Client;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
class HomeFeaturedProducts extends Component
{
	protected $baseUrl = 'https://products.excellentworldint.com/api/v1';
	private $httpClient;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => $this->baseUrl
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
	public function render(): View|Closure|string
	{
		$allCategories = [];
		$allProducts = [];

		try {
			// get categories and products from external API with adding categories and products at end of the url
			$categoryUrl = $this->baseUrl . '/categories';
			$productUrl = $this->baseUrl . '/products';

			$responseCategories = $this->httpClient->request('GET', $categoryUrl, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ]
            ]);

			$responseProducts = $this->httpClient->request('GET', $productUrl, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ]
            ]);

			if ($responseCategories->getStatusCode() === 200) {
				$allCategories = json_decode($responseCategories->getBody()->getContents(), true);
			} else {
				Log::error('Failed to fetch categories. Status code: ' . $responseCategories->getStatusCode());
			}

			if ($responseProducts->getStatusCode() === 200) {
				$allProducts = json_decode($responseProducts->getBody()->getContents(), true);
			} else {
				Log::error('Failed to fetch products. Status code: ' . $responseProducts->getStatusCode());
			}
		} catch (\Exception $e) {
			return 'Something went wrong: ' . $e->getMessage();
		}

		// dd($allProducts);

		return view('components.site.home-featured-products', [
			'categories' => $allCategories,
			'products' => $allProducts
		]);
	}
}

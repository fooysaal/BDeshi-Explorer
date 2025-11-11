<?php

namespace App\Http\Controllers\Site;

use Exception;
use Carbon\Carbon;
use App\Models\App\Cms\Faq;
use Illuminate\Support\Str;
use App\Models\App\Cms\Page;
use App\Models\App\Cms\Post;
use Illuminate\Http\Request;
use App\Mail\CustomerReplyMail;
use Illuminate\Support\Facades\DB;
use App\Mail\AdminNotificationMail;
use App\Models\App\Inventory\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\App\Cms\ContactUsQuery;
use App\Models\App\Inventory\InvOrder;
use App\Models\App\Cms\EmailSubscriber;
use App\Models\App\Inventory\InvCustomer;
use App\Http\Controllers\WwspBaseController;
use App\Repositories\App\Inventory\InvOrderRepository;

class SiteController extends WwspBaseController
{
	private $invOrderRepository;

	// public function __construct()
	// {
	// 	$this->invOrderRepository = new InvOrderRepository();
	// }

	public function loadPage($pageSlug = null, $pageSubSlug = null, $innerSlug = null)
	{
		if ($pageSlug) {

			if ($pageSubSlug) {
				if ($pageSubSlug === 'products' && !is_null($innerSlug)) {

					try {
						$baseUrl = 'https://products.excellentworldint.com/api/v1/products/' . $innerSlug;
						$response = Http::withHeaders([
							'Accept' => 'application/json',
							'Content-Type' => 'application/json'
						])->get($baseUrl);

						if ($response->successful()) {
							$productDetails = $response->json();
							$viewBag['productDetails'] = $productDetails;
						} else {
							abort(404);
						}

					} catch (Exception $e) {
						abort(404);
					}

					return view('site.contents.product-details', $viewBag);
				} else {
					abort(404);
				}
				// these are mainly posts by categories
				$singlePost = Post::with('tags')->where('slug', $pageSubSlug)
					->first();
				$viewBag['singlePost'] = $singlePost;

				if ($pageSlug == 'blog') {
					// load single news and events
					$pageTemplate = 'single-blog';

					$viewBag['recentBlogs'] = getPostsByCategories(['Blog']);

				} else {
					// $pageTemplate = 'blog-page';
					abort(404);
				}

				return view('site.templates.' . $pageTemplate, $viewBag);
			}

			$page = Page::where('slug', $pageSlug)->first();

			if ($page) {
				if ($page->slug == 'checkout') {
					// Check if the user is authenticated
					if (!Auth::check()) {
						return redirect('/login');
					}
				}
				$pageTemplate = is_null($page->pageTemplate) ? 'inner-page' : Str::slug($page->pageTemplate->name);


				if ($pageSlug === 'checkout' && auth()->check()) {
					// Retrieve the customer using the current user's ID
					$customer = InvCustomer::where('user_id', auth()->id())->firstOrFail();

					// Assuming `address` is a field in the `Customer` model
					$customerAddress = $customer->address;

					// put customer address tot session
					session(['customer_address' => $customerAddress]);
				}

				return view('site.templates.' . $pageTemplate);
			} else {
				abort(404);
			}
		}

		return view('site.templates.home-page');
	}

	function faq()
	{
		$faqs = Faq::whereHas('faqCategory', function ($query) {
			$query->where('name', 'like', '%faq%'); // Replace 'Example Name' with the actual category name
		})->active()->get();


		return view('site.pages.faq', compact(['faqs']));
	}

	public function checkout()
	{
		// Retrieve the cart from session
		$cart = session()->get('cart-products', []);

		// Ensure there is an authenticated user
		$user = Auth::user();

		// Retrieve the customer using the current user's ID
		$customer = InvCustomer::where('user_id', $user->id)->firstOrFail();

		// Assuming `address` is a field in the `Customer` model
		$customerAddress = $customer->address;

		// Pass the cart items and customer address to the view
		return view('site.contents.checkout', [
			'cart' => $cart,
			'customerAddress' => $customerAddress, // Pass the customer address to the view
		]);
	}

	public function storeCheckout(Request $request)
	{
		$request->validate([
			'delivery_method' => 'required',
			'total_amount' => 'required',
			'total_products' => 'required',
			'cart_items' => 'required|array',
			'cart_items.*.name' => 'required',
			'cart_items.*.quantity' => 'required|integer|min:1',
			'cart_items.*.price' => 'required|numeric|min:0',
		]);

		$statusID = Status::where('group_string', 'order')->where('name', 'Created')->first()->id;

		try {
			DB::transaction(function () use ($request, $statusID) {

				// shipping_meta as json
				$shippingMeta = [
					'delivery_method' => $request->delivery_method,
					'shipping_address' => $request->shipping_address ?? null,
				];

				// Create an order
				$order = InvOrder::create([
					'customer_user_id' => auth()->user()->id,
					'payment_method_id' => 1,
					'shipping_meta' => json_encode($shippingMeta),
					'total_price' => $request->total_amount,
					'total_products' => $request->total_products,
					'status_id' => $statusID ?? null,
				]);

				// Make Order Number and update the order
				$order->order_number = $this->makeOrderNumber($order->id);
				$order->save();

				// Prepare the order details array
				$details = [];
				foreach ($request->cart_items as $product) {
					$details[] = [
						'inv_order_id' => $order->id,
						'inv_product_name' => $product['name'],
						'quantity' => $product['quantity'],
						'sale_amount' => $product['price'],
					];
				}

				// Insert the order details in bulk
				$order->details()->createMany($details);
			});

			// Return success response
			return response()->json(['message' => 'Order Placed Successfully!', 'status' => 'success'], 201);
		} catch (Exception $e) {
			// Handle the exception, roll back is automatic
			return response()->json([
				'message' => 'An error occurred while placing the order.',
				'error' => $e->getMessage(),
			], 500);
		}
	}

	public function makeOrderNumber($id)
	{
		return 'INV-' . str_pad($id, 6, '0', STR_PAD_LEFT);
	}

	// public function showOrder($order)
	// {
	// 	$order = $this->orderRepository->orderDetails($order);

	// 	return view('site.pages.order-details', compact('order'));
	// }

	// public function printOrder($order)
	// {
	// 	$order = $this->invOrderRepository->orderDetails($order);

	// 	// Decode JSON if it's a string
	// 	if (is_string($order->shipping_meta)) {
	// 		$order->shipping_meta = json_decode($order->shipping_meta, true);
	// 	}

	// 	return view('site.pages.print-order', compact('order'));
	// }

	public function contactUsStore(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'email' => 'required|email',
			'query_message' => 'required',
		]);

		// Check if this is the Booking Form submission
		if ($request->input('scheduleBooking') === 'booking form') {
			$request->validate([
				'date_and_time' => 'required|date_format:Y-m-d\TH:i', // Match input format
			]);

			$query = new ContactUsQuery();
			$query->name = $request->name;
			$query->email = $request->email;
			$query->query_message = $request->query_message;
			$query->message_form = 'BookingForm';
			$query->date_and_time = Carbon::parse($request->date_and_time)->format('Y-m-d H:i:s'); // Convert format
			$query->is_read = false;
			$query->save();

			// Send email to customer (Auto-reply)
			Mail::to($request->email)->send(new CustomerReplyMail($query));

			// Send email to admin (Notification)
			Mail::to('arrajivkhan@gmail.com')->send(new AdminNotificationMail($query));

			return redirect()->back()->with('success', 'Your booking request has been submitted successfully.');
		} else {

			$query = new ContactUsQuery();
			$query->name = $request->name;
			$query->email = $request->email;
			$query->query_message = $request->query_message;
			$query->message_form = 'ContactForm';
			$query->is_read = false;
			$query->save();
			return response()->json([
				'status' => 'success',
				'message' => 'Your query has been submitted successfully.'
			]);
		}
	}


	public function emailSubscribers(Request $request)
	{
		$request->validate([
			'email' => 'required|email|unique:email_subscribers,email'
		]);

		$applicant = new EmailSubscriber();
		$applicant->email = $request->email;
		$applicant->save();

		return response()->json([
			'status' => 'success',
			'message' => 'Subscribed Newsletter successfully.'
		]);
	}

	public function login()
	{
		return view('site.pages.auth.login');
	}

}

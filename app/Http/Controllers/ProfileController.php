<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\FileUpload;
use App\Models\FileUploadCategory;
use App\Models\VideoUpload;
use App\Models\Purchase;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Blogs;
use App\Models\Package;
use App\Models\Comment;
use Illuminate\View\View;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionConfirmation;
use App\Models\ReelsUpload;
use Stevebauman\Location\Facades\Location;
use DB;
use Hash;
use Carbon\Carbon;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Container\Container;
use setasign\Fpdi\Fpdi;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function welcome()
    {
        $blogs = Blogs::get();
        $unpaid = [];
        $transcripts = [];
        $custom_id = [2, 5, 6, 7, 8, 10, 11, 13, 23];

        if (Auth::check()) {
            $userId = Auth::id();
            //     $paid = FileUpload::whereHas('purchases', function ($query) use ($userId) {
            //         $query->where('user_id', $userId);
            //     })->orderBy('id', 'asc')->paginate(8);

            $unpaid = FileUpload::whereIn('id', $custom_id)->orderBy('created_at', 'asc')->paginate(8);
            // $unpaid = FileUpload::whereDoesntHave('purchases', function ($query) use ($userId) {
            //     $query->where('user_id', $userId);
            // })->whereIn('id',$custom_id)->orderBy('created_at', 'asc')->paginate(8);

            //     $transcripts = [];
        } else {
            //     $paid = [];

            $transcripts = FileUpload::whereIn('id', $custom_id)->orderBy('created_at', 'asc')->paginate(8);
        }
        $lowestPackage = Package::orderBy('amount', 'asc')->first();

        return view('welcome', compact('blogs', 'unpaid', 'transcripts', 'lowestPackage'));
    }
    
    public function about_us()
    {
        return view('about-us');
    }

    public function services()
    {
        return view('services');
    }

    public function video_reels()
    {
        try {
            $reels = ReelsUpload::get();
            return view('video-reels', compact('reels'));
        } catch (\Exception $e) {
            // Handle exceptions (e.g., network issues)
            return view('your.error_view');
        }
    }


    public function video_series()
    {
        $videos = VideoUpload::get();
        $package = Package::get();
        $ip = '103.125.71.48';
        // $ip = request()->ip;
        // Get the user's country and currency code based on IP address
        $location = Location::get($ip);
        $userCurrencyCode = $location->currencyCode;
        // Fetch exchange rates using the API key from the environment
        $apiKey = config('laravel-exchange-rates.api_key');
        $baseCurrency = 'USD'; // You can set your default currency
        $endpoint = "https://open.er-api.com/v6/latest/{$baseCurrency}?apikey={$apiKey}";

        try {
            $response = Http::get($endpoint);

            if ($response->successful()) {
                $exchangeRates = $response->json('rates');
                // Convert package prices to the user's currency
                // Check if the user's currency code exists in the exchange rates data
                if (isset($exchangeRates[$userCurrencyCode])) {
                    $convertedAmount = $exchangeRates[$userCurrencyCode];
                }
                return view('video-series', compact('videos', 'package', 'location', 'userCurrencyCode', 'convertedAmount'));
            } else {
                // Handle API error
                return view('your.error_view');
            }
        } catch (\Exception $e) {
            // Handle exceptions (e.g., network issues)
            return view('your.error_view');
        }
    }

    public function incrementViews($videoId)
    {
        $video = VideoUpload::find($videoId);
        if ($video) {
            // Increment views by 25
            $video->increment('views', 25);
            return response()->json([
                'success' => true,
                'views' => $video->views
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Video not found'
        ], 404);
    }

    public function transcripts()
    {

        $FileUploadCategory = 'assets/Dev_PDF.pdf';
        $url = asset('' . $FileUploadCategory);

        return view('transcript-summaries', compact('url'));

        // return view('transcript-summaries');
    }

    public function AllTranscript()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $paid = FileUpload::whereHas('purchases', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->orderBy('created_at', 'asc')->get();

            $unpaid = FileUpload::whereDoesntHave('purchases', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->orderBy('created_at', 'asc')->get();

            $transcripts = [];
        } else {
            $paid = [];
            $unpaid = [];
            $transcripts = FileUpload::orderBy('created_at', 'asc')->get();
        }

        return view('all-transcripts', compact('transcripts', 'paid', 'unpaid'));
    }

    public function transcripts_inner()
    {
        return view('transcripts_inner');
    }

    public function blogs()
    {
        $blogs = Blogs::get();
        return view('blogs', compact('blogs'));
    }

    public function InnerBlogs($id)
    {
        $inner_blogs = Blogs::where('id', $id)->first();
        $comments = Comment::get();
        return view('inner-blogs', compact('inner_blogs', 'comments'));
    }

    public function contact_us()
    {
        return view('contact-us');
    }

    public function ContactStore(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'required|email',
            'subject' => 'nullable',
            'message' => 'required',
        ]);

        Contact::create($validatedData);
        return redirect()->back()->with('success', 'Message sent successfully');
    }

    //public function renders($id)
    //{
    //$purchase = Purchase::where('file_id',$id)->first();
    //$FileUploadCategory = FileUploadCategory::where('file_category_id',$purchase->category_id)->first();
    //$transcripts = FileUpload::where('id',$id)->first();

    // Fetch the PDF file based on the $file parameter
    //$pdfFilePath = asset('storage/' . $FileUploadCategory->file_path);
    // Pass the PDF file path to the view for rendering
    //return view('transcripts-inner', compact('pdfFilePath','transcripts'));
    //}
    public function renders($id)
    {
        $userId = Auth::user()->id;
        $FileUpload = FileUpload::with('categories', 'FileCategory', 'purchases')->whereHas('purchases', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('id', $id)->first();
        $FileCat = Purchase::with('FileUploadCategory')->where('file_id', $id)->where('user_id', $userId)->get();

        $transcripts = FileUpload::where('id', $id)->first();
        return view('transcripts-inner', compact('transcripts', 'FileCat', 'FileUpload'));
    }

    public function payNow($id)
    {
        $package = Package::where('id', $id)->first();
        return view('pay', compact('package'));
    }

    public function ProductBuyPayment(Request $request)
    {
        return view('product_buy_payment');
    }


    public function productBuyNow($id)
    {
        $product = FileUpload::with('FileCategory', 'FileCategory.Category')->where('id', $id)->first();
        $categories = Category::all();
        return view('product_buy', compact('product', 'categories'));
    }

    public function NewsLetter(Request $request)
    {

        $request->validate([
            'email' => 'required|email|unique:email_comformation',
        ]);

        // Create a new subscriber
        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        // Send confirmation email
        Mail::to($request->email)->send(new SubscriptionConfirmation());
        return response()->json(['success' => 'Confirmation email sent.']);
    }
}

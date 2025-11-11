<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Logo;
use App\Models\User;
use App\Models\UserPackage;
use App\Product;
use App\Models\JokeUser;
use App\Models\Property;
use App\Models\FileUpload;
use App\Models\Purchase;

use App\Inquiry;
use App\Models\Joke;
use App\Models\IsRead;
use App\Models\Package;
use App\Models\VideoUpload;

use Stevebauman\Location\Facades\Location;
use DB;
use Auth;
use Hash;
use Carbon\Carbon;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Container\Container;
use setasign\Fpdi\Fpdi;



class DashboardController extends Controller
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function index()
    {
        $files = FileUpload::get();
        return view('user.dashboard', compact('files'));
    }

    public function Transcript()
    {
        $userId = Auth::id();

        $paidFiles = FileUpload::with('FileCategory')->whereHas('purchases', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        $unpaidFiles = FileUpload::whereDoesntHave('purchases', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return view('user.users.transcript', compact('paidFiles', 'unpaidFiles'));
    }

    public function AllTranscript()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $transcripts = FileUpload::whereDoesntHave('purchases', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->get();
        } else {
            $transcripts = FileUpload::all();
        }
        return view('all-transcripts', compact('transcripts'));
    }

    //     public function productBuy($id){
    //         $product = FileUpload::where('id',$id)->first();
    // return $product;
    //         return view('product_buy',compact('product'));
    //     }

    public function BuyNow($id)
    {
        $userId = Auth::id();

        $BuyNow = new Purchase();
        $BuyNow->user_id = $userId;
        $BuyNow->file_id = $id;
        $BuyNow->save();

        $paidFiles = FileUpload::whereHas('purchases', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        $unpaidFiles = FileUpload::whereDoesntHave('purchases', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return view('user.users.transcript', compact('paidFiles', 'unpaidFiles'));
    }



    public function Video()
    {
        $videos = VideoUpload::get();
        return view('user.users.video', compact('videos'));
    }




    public function change_password()
    {
        return view('user.layouts.changePassword');
    }

    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['error   ' => 'The current password is incorrect.']);
        }

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        return redirect()->route('user.dashboard')->with('success', 'Password successfully changed');
    }

    public function user_joke()
    {
        $user = auth()->user();
        $allowedJokesCount = $user->total_jokes;
        $jokes = Joke::with('isRead')->take($allowedJokesCount)->get();
        return view('user.users.jokes', compact('jokes'));
    }

    public function purchasePackage(Request $request)
    {
        return $request->all();
    }

    public function purchasePackageCreate()
    {
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
                return $exchangeRates;
                // Convert package prices to the user's currency
                // Check if the user's currency code exists in the exchange rates data
                if (isset($exchangeRates[$userCurrencyCode])) {
                    $convertedAmount = $exchangeRates[$userCurrencyCode];
                }
                return view('user.users.packages', compact('package', 'location', 'userCurrencyCode', 'convertedAmount'));
            } else {
                // Handle API error
                return view('your.error_view');
            }
        } catch (\Exception $e) {
            // Handle exceptions (e.g., network issues)
            return view('your.error_view');
        }
    }

    public function PuchasePackage(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);
        $user = auth()->user();
        $packageId = $request->input('package_id');

        // Check if the user has already purchased the package
        $existingPurchase = UserPackage::where('user_id', $user->id)
            ->where('package_id', $packageId)
            ->first();
        if (!$existingPurchase) {
            // Create a new user-package association if it doesn't exist
            UserPackage::create([
                'user_id' => $user->id,
                'package_id' => $packageId,
            ]);

            $user = User::where('id', $user->id)->first();
            $user->payment_status = 1;
            $user->save();

            return response()->json(['message' => 'Package purchased successfully']);
        } else {
            return response()->json(['error' => 'You have already purchased this package']);
        }
    }

    public function show($id)
    {
        $jokes = Joke::take(5)->latest()->get();
        if (auth()->check()) {
            $user = auth()->user();
            if (!empty($user)) {
                $createdAt = Carbon::parse($user->created_at)->format('Y-m-d');
                $now = Carbon::parse()->format('Y-m-d');
                $userReadJokes = $user->readJokes()->where('joke_id', $id)->first();
                if (empty($userReadJokes)) {
                    // Retrieve the joke by ID
                    $joke = Joke::findOrFail($id);
                    $remaining = $user->no_of_jokes - 1;
                    if ($user->no_of_jokes > 0) {
                        $user->readJokes()->attach($joke);
                        $user->no_of_jokes = $remaining;
                        $user->save();
                    }
                    if ($remaining == 0) {
                        $user->payment_status = 0;
                        $user->save();
                    }
                }
                if ($user->no_of_jokes == 0) {
                    $responseData = [
                        'success' => true,
                        'message' => 'No of jokes already used please purchase Package',
                    ];
                    return response()->json($responseData);
                }
            }
        }
    }

    public function markAsRead(Request $request, $notificationId)
    {

        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        return redirect()->back()->with('success', 'Read successfully!');
    }


    public function PDFShow($path)
    {
        // Assuming you have the setasign/fpdi library installed
        // You can install it using: composer require setasign/fpdi

        // Initialize FPDI
        $pdf = new Fpdi();
        dd($pdf);
        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('Arial', 'B', 16);

        // Set text color to black
        $pdf->SetTextColor(0, 0, 0);

        // Set the path to the PDF file
        $pdfPath = storage_path('app/public/' . $path);

        // Load the PDF
        $pdf->setSourceFile($pdfPath);

        // Import the first page from the PDF
        $tplId = $pdf->importPage(1);

        // Use the imported page as a template
        $pdf->useTemplate($tplId, 10, 10, 200);

        // Output the PDF to the browser
        $pdf->Output();
    }
}

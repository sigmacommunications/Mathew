<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Mail\EventRegistrationConfirmationMail;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\View\View;
use App\Models\Blogs;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\FileUpload;
use App\Models\Transaction;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class FrontendController extends Controller
{
    public function index(): View
    {
        $settings = Setting::first();
        return view('welcome', compact('settings'));
    }

    public function AboutUs(): View
    {
        $settings = Setting::first();
        return view('about-us', compact('settings'));
    }

    public function Blog()
    {
        $blogs = Blogs::get();
        $settings = Setting::first();
        return view('blogs', compact('settings', 'blogs'));
    }

    public function Contact()
    {
        $settings = Setting::first();
        return view('contact-us', compact('settings'));
    }

    public function PrivacyPolicy()
    {
        $settings = Setting::first();
        return view('privacy-policy', compact('settings'));
    }

    public function TermsAndConditions()
    {
        $settings = Setting::first();
        return view('terms-and-conditions', compact('settings'));
    }

    public function GetInTouch(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|string|max:10',
            'contact_no' => 'required|string|max:15',
            'subject' => 'required|string|max:255',
            'comment' => 'nullable|string|max:1000',
          ]);
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->country_code . $request->contact_no,
            'subject' => $request->subject,
            'message' => $request->comment,
        ]);
        Mail::to($request->email)->send(new ContactMail($validatedData));
        return back()->with('success', 'Your message has been sent successfully.');
    }

    public function Event()
    {
        // Fetch all events
        $events = Event::all();

        // Prepare events data for FullCalendar
        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->event_date,
                'description' => $event->description, // ✅ Make sure this is not null
                'allDay' => true,
                'color' => '#378006',
                'textColor' => '#ffffff'
            ];
        }

        // Pass events data to the view as JSON
        return view('events', [
            'eventsJson' => json_encode($data),
            'isLoggedIn' => auth()->check(), // ✅ Check if user is authenticated
        ]);
    }

    public function EventRegistration(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string',
            'email' => 'required',
            'description' => 'nullable|string',
            'stripe_token_id' => 'required|string',
        ]);

        // Step 1: Create event registration
        $registration = EventRegistration::create([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'email' => $request->email,
            'description' => $request->description,
        ]);

        // Step 2: Create transaction
        try {
            Transaction::create([
                'user_id' => Auth::id(),
                'event_id' => $request->event_id,
                'event_registration_id' => $registration->id,
                'stripe_token_id' => $request->stripe_token_id,
                'amount' => 5,
            ]);
        } catch (\Exception $e) {
            Log::error('Transaction failed: ' . $e->getMessage());
            return response()->json(['error' => 'Transaction failed'], 500);
        }

        $event = Event::find($request->event_id);
        Mail::to($request->email)->send(new EventRegistrationConfirmationMail($registration, $event));

        return response()->json(['success' => true]);
    }

    public function StudyMaterial()
    {
        $files = FileUpload::with('categories')->orderBy('created_at', 'asc')->get();
        return view('study-material', compact('files'));
    }

    public function StudyMaterialView($id)
    {

        $details = FileUpload::with('FileCategory')->findOrFail($id);

        $fileCategories = $details->FileCategory->map(function ($cat) {
            return [
                'price' => (float) $cat->amount,
            ];
        })->toArray();
        $prices = array_column($fileCategories, 'price');
        $minPrice = min($prices);
        $maxPrice = max($prices);

        $categoryIds = $details->FileCategory->pluck('file_category_id')->unique();
        $categories = Category::whereIn('id', $categoryIds)->get();

        return view('study-material-detail', compact('details', 'minPrice', 'maxPrice', 'categories'));
    }
}

<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Logo;
use App\Models\User;
use App\Models\Package;
use App\Product;
use App\Models\Property;
use App\Inquiry;
use DB;
use Auth;
use Hash;
use App\Notifications\SubscripNotification;

class DashboardController extends Controller
{

    public function change_password()
    {
        return view('admin.layouts.changePassword');
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
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()->route('admin.dashboard')->with('success','Password successfully changed');
    }
	
	public function mansubscribePackage(Request $request){
		
		$package = Package::find($request->package);
		$user = User::find($request->userId);
		$user->payment_status = 1;
		$user->no_of_jokes = $package->no_of_jokes;
		$user->total_jokes = $package->no_of_jokes;
		$user->save();
		
		$userName = $user->name;
		$packageName = $package->name;
		
		auth()->user()->notify(new SubscripNotification($userName, $packageName));
		
		// Notify the user associated with the package
    	$user->notify(new SubscripNotification($userName, $packageName));
		
		return redirect()->back()->with('success','Package Subscribe successfully!');
	}


    public function markAsRead(Request $request, $notificationId)
    {   
        
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return redirect()->back()->with('success','Read successfully!');
       
    }

   
}

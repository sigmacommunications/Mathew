<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Notifications\UserRegisterNotification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
	
	  public function store(Request $request)
    {
		  
         $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);
        $data=$request->all();
		
		$user = 'User'; 
        $data['password']=Hash::make($request->password);
        $status=User::create($data);
		$status->assignRole($user);
         	$users =User::where('id',$status->id)->first(); 
			$users->notify(new UserRegisterNotification);
			$Adminuser = User::where('name','Admin')->first();
			$Adminuser->notify(new UserRegisterNotification);
	       if ($status) {
			   return redirect()->to('/login')->with('success', 'Successfully added user');
		   } else {
			   return redirect()->back()->with('error', 'Error occurred while adding user');
		   }
		  
       

    }
    
}

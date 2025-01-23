<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
//use Illuminate\Auth\Events\Registered;
//use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Events\UserRegistered;
 

class RegisteredUserController extends Controller
{
   
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request) 
    {
        
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
                'password' => ['required', Rules\Password::defaults()],
            ]);
        
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        
            // return response()->json([
            //     'message' => 'User registered successfully!',
            //     'user' => $user,
            // ], 201); // Return a 201 status for created resources
            auth()->login($user);
            $token = $user->createToken('token')->plainTextToken;
            $userProfile = UserProfile::create([
                'title' => $request->name,
                'user_id' => $user->id,
                
                
            ]);
            event(new UserRegistered($user)); // Trigger the event
            //return $this->successResponse($user, 'User registered successfully');
            return response()->json(['token' => $token, 'user' => $user]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422); // 422 Unprocessable Entity for validation errors
        }
        //Auth::login($user);

        //return redirect(route('dashboard', absolute: false));
    }

     

}

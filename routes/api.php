<?php
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// Register Route
Route::post('register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:8',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return response()->json($user, 201);
});

// Login Route
Route::post('login', function (Request $request) {
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string|min:8',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();
        $token = $user->createToken('UpworkToken')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
});

// Protected User Route
Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return response()->json($request->user());
});

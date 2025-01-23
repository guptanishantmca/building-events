<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Work;
 
 
 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
 
 

class WorkController extends Controller
{
    public function createJob(Request $request) 
    {
       //dd($request);
        
        try {
            $request->validate([
                'jobTitle' => 'required|string|max:255',
                'jobDescription' => 'required|string',
                
            ]);
        
            $Work = Work::create([
                'title' => $request->jobTitle,
                'description' => $request->jobDescription,
                'client_id' => Auth::id(),
                 
            ]);
        
             
            return response()->json([  'work' => $Work]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);  
        }
        
    }
}

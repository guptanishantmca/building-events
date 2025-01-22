<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Work;
 
 
 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Traits\ApiResponse;
 

class WorkController extends Controller
{
    public function createJob(Request $request) 
    {
        
        
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                
            ]);
        
            $Work = Work::create([
                'title' => $request->title,
                'description' => $request->description,
               
                 
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

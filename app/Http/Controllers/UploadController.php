<?php

namespace App\Http\Controllers;  

use Illuminate\Http\Request;  

class UploadController extends Controller  
{  
    public function upload(Request $request)  
    {  
        $validatedData = $request->validate([  
            'file' => 'required|file|mimes:jpg,png,jpeg|max:2048', // Optional: Change the validation rules as per requirements  
        ]);  
    
        try {  
            // Check if the file exists  
            if ($request->hasFile('file')) {  
                // Store the uploaded file  
                $path = $request->file('file')->store('uploads', 'public'); // Store in storage/app/public/uploads  
                
                // Return success response with file path or other relevant info  
                return response()->json(['success' => true, 'message' => 'File uploaded successfully', 'path' => $path], 200);  
            } else {  
                // Return error response if no file found  
                return response()->json(['success' => false, 'message' => 'No file provided'], 400);  
            }  
        } catch (\Exception $e) {  
            // Log the error message for debugging purposes  
            \Log::error("File upload error: " . $e->getMessage());  
    
            // Return error response  
            return response()->json(['success' => false, 'message' => 'An error occurred while uploading the file', 'error' => $e->getMessage()], 500);  
        }  
    }  
} 
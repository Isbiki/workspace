<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller {
    
    /**
     * Display Category members of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(){
        $categories = DB::table('categories')->orderby('created_at', 'desc')->get();
        if($categories->isNotEmpty()){
            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ]);
        }
    }
    public function store(Request $request){  
        try {  
            $validators = Validator::make($request->all(), Category::rules());  
            if ($validators->fails()) {  
                return response()->json([  
                    'success' => false,  
                    'message' => 'Validation Error',   
                ]);  
            } else {  
                $category = Category::create($request->all());  
                
                if ($category) {  
                    return response()->json([  
                        'success' => true,  
                        'message' => 'Successfully created',  
                        'Category' => $category,  
                    ]);  
                } else {  
                    return response()->json([  
                        'success' => false,  
                        'message' => 'Cannot save.',  
                    ]);  
                }  
            }  
        } catch (\Throwable $e) {  
            \Log::error($e); // Log the error  
            return response()->json([  
                'success' => false,  
                'message' => 'An error occurred',  
                'error' => $e->getMessage(),  
            ], 500);  
        }  
    }  
    public function update(Request $request, $id)  
    {  
        $validators=Validator::make($request->all(), Category::rules());
        if($validators->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'validation failed'
                ]);
        }  
        $category = Category::findOrFail($id);  
        $category->fill($request->all());
        if($category->save()){
            return response()->json(['success' => true, 'message' => 'Category updated successfully!', 'category' => $category]);
        }
        else{
            return response()->json(['success' => false, 'message' => 'Can not save updated Category', 'category' => $category]);
        }
    }  

    public function destroy($id) 
    {  
        try {  
            $category = Category::findOrFail($id);  
            $category->delete();  
            return response()->json(['success' => true, 'message' => 'Category deleted successfully'], 200);   
        } catch (ModelNotFoundException $e) {  
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);  
        } catch (\Exception $e) {  
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);  
        }   
    }  
    
}
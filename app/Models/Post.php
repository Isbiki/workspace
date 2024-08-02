<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;

class Post extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'category_id',
        'description',
        'user_id',
        'breaking',
        'active',
    ];

    public static function rules()  
    {  
        return [  
            'title' => 'required|string|max:255', 
            'subtitle' => 'nullable|string|max:255',
            'category_id' => 'required|integer',
            'user_id' => 'required|integer',
            'breaking' => 'required|integer',
            'description' => 'required|string',
            
        ];  
    } 

    protected $table = 'posts';

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comments()  
    {  
        return $this->hasMany(Comment::class);  
    } 
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    
}

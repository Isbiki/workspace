<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
use App\Models\Post;

class Category extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'kind',
        'parent_name',
        'status',
        'position',
        'type1',
        'type2',
        'homepage',
        'sort_order',
        'data_query',
        'avatar',
    ];

    protected $table = 'categories';

    public static function rules()  
    {  
        return [  
            'name' => 'required|string|max:255', 
            'parentname' => 'nullable|string|max:255',
            'data_query' => 'required|string|max:255',
            'avatar' => 'required|string|max:255',
            'kind' => 'required|integer',
            'status' => 'required|integer',
            'position' => 'required|integer',
            'type1' => 'required|integer',
            'type2' => 'required|integer',
            'homepage' => 'required|integer',
            'sort_order' => 'required|integer',
        ];  
    } 
    public function posts()  
    {  
        return $this->hasMany(Post::class);  
    } 
    
}

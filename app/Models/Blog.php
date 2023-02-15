<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'post',
        'post_excerpt',
        'slug',
        'user_id',
        'featuredImage',
        'metaDescription',
        'view',
        'jsonData'
    ];

    //slug
    public function setSlugAttribute($title)
    {
        $this->attributes['slug'] = $this->uniqueSlug($title);
    }

    public function uniqueSlug($title)
    {
        $slug = Str::slug($title, '-');
        $count = Blog::where('slug', 'LIKE', "{$slug}%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function tag()
    {
        return $this->belongsToMany('App\Models\Tag', 'blogtags');
    }
    public function cat()
    {
        return $this->belongsToMany('App\Models\Category', 'blogcategories');
    }
}

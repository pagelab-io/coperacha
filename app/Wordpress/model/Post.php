<?php

namespace App\Wordpress\model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //region attributes
    protected $primaryKey = 'ID';
    
    /**
     * The database table used by the model
     *
     * @var string
     */
    protected $table = 'wp_posts';

    /**
     * These are the mass-assignable keys
     *
     * @var string[]
     */
    protected $fillable = ['post_author', 'post_date', 'post_content', 'post_title'];
    //endregion

    /**
     * Get all of the product's files.
     *
     * @return mixed
     */
    public function getFiles() {
        $files = Post::where('post_parent', $this->ID)
            ->where('post_type','attachment')
            ->get();

        return $files;
    }

    /**
     * Get parent record of this
     *
     * @return mixed
     */
    public function getParent() {
        return Post::where('post_parent', $this->ID)->first();
    }
    
    /**
     * Main image of the post
     * @return null
     */
    public function getMainImage() {
        $files = $this->getFiles();
        
        if (count($files) > 0) {
            return $files->last();
        }

        return null;
    }

    /**
     * Get all of the post's page.
     *
     * @return mixed
     */
    public function getChildrens() {
        $brands = Post::where('post_parent', $this->ID)
            ->where('post_type','page')
            ->get();

        return $brands;
    }

    /**
     * Scope a query to only include post of a given name
     *
     * @param $query
     * @param $postname
     */
    public function scopeByPostName($query, $postname) {
        return $query->where('post_name', '=', $postname)
            ->where('post_type', 'page')
            ->where('post_status', 'publish');
    }
}

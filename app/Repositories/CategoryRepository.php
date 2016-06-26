<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:18 PM
 */

namespace App\Repositories;

use Illuminate\Container\Container as App;
use App\Http\Requests\PLRequest;
use App\Models\Category;

class CategoryRepository extends BaseRepository{

    //region attributes

    /**
     * @var Category
     */
    private $_category = null;

    //endregion

    //region Static
    //endregion

    public function __construct(Category $Category, App $app){
        parent::__construct($app);
        $this->_category = $Category;
    }

    //region Methods

    /**
     * return namesapace for Category Model
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Category';
    }

    /**
     * Create a new category
     *
     * @param PLRequest $request
     * @return Category
     * @throws \Exception
     */
    public function create(PLRequest $request)
    {
        \Log::info("=== Category create ===");
        $this->_category->name = $request->get('name');
        if (!$this->_category->save()) throw new \Exception("Unable to create Category", -1);
        \Log::info("=== Category created successfully : ".$this->_category." ===");
        return $this->_category;
    }

    /**
     * Get all categories
     *
     * @return mixed
     */
    public function getALl()
    {
        \Log::info("=== get all categories ===");
        return $this->all();
    }

    //endregion

    //region Private Methods
    //endregion
}
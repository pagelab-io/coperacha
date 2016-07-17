<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:18 PM
 */

namespace App\Repositories;

use App\Http\Responses\PLResponse;
use Illuminate\Container\Container as App;
use App\Http\Requests\PLRequest;
use App\Entities\Category;

class CategoryRepository extends BaseRepository{

    //region attributes

    /**
     * @var Category
     */
    private $_category;

    //endregion

    //region Static
    //endregion

    public function __construct(App $app, Category $Category){
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
        return 'App\Entities\Category';
    }

    /**
     * Create a new category
     *
     * @param PLRequest $request
     * @return PLResponse
     * @throws \Exception
     */
    public function create(PLRequest $request)
    {
        $response = new PLResponse();

        \Log::info("=== creating Category ===");
        $this->_category->name = $request->get('name');
        if (!$this->_category->save()) throw new \Exception("Unable to create Category", -1);
        \Log::info("=== Category created successfully : ".$this->_category." ===");

        $response->description  = "category was added successfully";
        $response->data         = $this->_category;

        return $response;
    }

    /**
     * Get all categories
     *
     * @return PLResponse
     */
    public function getALl()
    {
        \Log::info("=== get all categories ===");
        $response               = new PLResponse();
        $response->description  = 'listing all categories successfully';
        $response->data         = $this->all();
        return $response;
    }

    //endregion

    //region Private Methods
    //endregion
}
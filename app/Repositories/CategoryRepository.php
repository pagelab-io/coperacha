<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:18 PM
 */

namespace App\Repositories;


use App\Models\Category;

class MoneyboxCategoryRepository extends BaseRepository{

    //region attributes

    /**
     * @var Category
     */
    private $_category = null;

    //endregion

    //region Static
    //endregion

    public function __construct(Category $Category){
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

    //endregion

    //region Private Methods
    //endregion
}
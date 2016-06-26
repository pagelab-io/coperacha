<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 26/06/2016
 * Time: 11:51 AM
 */

namespace App\Http\Controllers\Moneybox;


use App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryController extends PLController{

    //region Attributes
    /**
     * @var CategoryRepository
     */
    private $_categoryRepository;
    //endregion

    //region Static Methods
    //endregion

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->_categoryRepository = $categoryRepository;
    }

    //region Private Methods
    //endregion

    //region Methods

    /**
     * Create a new category
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCategory(PLRequest $request)
    {
        // validate the request
        $this->validate($request,$request->rules(),$request->messages());

        try {
            $category = $this->_categoryRepository->create($request);
            if($category instanceof Category)
            {
                $this->_response['description'] = "category was added successfully";
                $this->_response['data'] = $category;
            }
            return response()->json($this->_response);

        } catch(\Exception $ex) {
            $this->_response['status'] = $ex->getCode();
            $this->_response['description'] = $ex->getMessage();
            $this->_response['data'] = $ex->getTraceAsString();
            return response()->json($this->_response);
        }
    }

    /**
     * Get all categories in the database
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        try {
            $this->_response['data'] = $this->_categoryRepository->getALl();
            return response()->json($this->_response);
        } catch(\Exception $ex) {
            $this->_response['status'] = $ex->getCode();
            $this->_response['description'] = $ex->getMessage();
            $this->_response['data'] = $ex->getTraceAsString();
            return response()->json($this->_response);
        }
    }

    //endregion

} 
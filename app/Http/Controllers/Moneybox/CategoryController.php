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
use App\Entities\Category;
use App\Http\Responses\PLResponse;
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
            $this->setResponse($this->_categoryRepository->create($request));
            return response()->json($this->getResponse());

        } catch(\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
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
            $this->setResponse($this->_categoryRepository->getALl());
            return response()->json($this->getResponse());
        } catch(\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }
    }

    //endregion

} 
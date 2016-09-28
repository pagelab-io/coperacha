<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 25/06/2016
 * Time: 05:02 PM
 */

namespace App\Http\Controllers\Moneybox;

use App\Entities\File;
use App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;;
use Illuminate\Http\Request;
use App\Http\Responses\PLResponse;
use App\Repositories\MoneyboxRepository;
use App\Repositories\MemberSettingRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MoneyboxController extends PLController
{

    //region Attributes
    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

    /**
     * @var MemberSettingRepository
     */
    private $_memberSettingsRepository;

    //endregion

    //region Static Methods
    //endregion

    public function __construct(MoneyboxRepository $moneyboxRepository, MemberSettingRepository $memberSettingsRepository)
    {
        $this->_moneyboxRepository = $moneyboxRepository;
        $this->_memberSettingsRepository = $memberSettingsRepository;
    }

    //region Private Methods
    //endregion

    //region Methods

    /**
     * Get all moneyboxes
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(PLRequest $request)
    {
        $this->validate($request, $request->rules(), $request->messages());

        try {
            $this->setResponse($this->_moneyboxRepository->getAll($request));
            return response()->json($this->getResponse());
        } catch (\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }
    }
    
    /**
     * Create a new moneybox
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMoneybox(PLRequest $request)
    {
        try {
            $this->validate($request, $request->rules(), $request->messages());
            $this->setResponse($this->_moneyboxRepository->create($request));
            return response()->json($this->getResponse());
        } catch (\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }
    }

    /**
     * Update the selected Moneybox
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMoneybox(PLRequest $request)
    {
        $this->validate($request, $request->rules(), $request->messages());

        $moneybox = null;

        try {
            $this->setResponse($this->_moneyboxRepository->updateMoneybox($request));
            return response()->json($this->getResponse());
        } catch (\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request) {

        if ($request->hasFile('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $filename = $request->file('file')->getClientOriginalName();
            $mine = $request->file('file')->getClientMimeType();
            $size = $request->file('file')->getSize();
            $name =  uniqid() . '_' . $filename;

            $temp = $request->file('file');

            if ($stored = Storage::disk('uploads')->put($name, \File::get($temp))) {
                $file = File::create(['name' => $name, 'size' => $size, 'path' => 'uploads', 'extension' => $extension]);
                $file->user_id = Auth::user()->id;
                $file->metadata = $mine;
                $file->storable_type = 'App\Entities\Moneybox';
                $file->storable_id = $request->get('id');
                $file->save();
            }
        }

        return response()->json(['success' => true, 'data' => $file]);
    }


    /**
     * @param $filename
     * @return Response
     */
    public function getMoneyboxImage($filename)
    {
        $file = Storage::disk('uploads')->get($filename);
        return new Response($file, 200);
    }

    public function getParticipants(PLRequest $request)
    {
        try {
            $this->setResponse($this->_moneyboxRepository->getParticipants($request->get('moneybox_id')));
            return response()->json($this->getResponse());
        } catch (\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }
    }

    //endregion
}

<?php

namespace App\Http\Controllers\Fingerprint;

use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Employee\ValidateBasicInfoRequest;
use App\Http\Resources\Fingerprint\FingerprintListResource;
use App\Http\Resources\Fingerprint\SubmitFingerprintResource;
use App\Services\Fingerprint\FingerPrintService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FringerprintController extends AdminBaseController
{
    public function __construct(FingerPrintService $fingerprintService) {
        $this->fingerprintService = $fingerprintService;
        $this->title = "BattleHR | Fingerprint";
        $this->path = "fingerprint/index";

    }
    public function getData(Request $request)
    {
        try {
            $data = $this->fingerprintService->getData($request);

            $result = new FingerprintListResource($data);
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
    public function deleteFingerprint($id)
    {
        try {
            DB::beginTransaction();
            $data = $this->fingerprintService->deleteData($id);

            $result = new SubmitFingerprintResource($data, 'Success Delete Employee');
            DB::commit();
            return $this->respond($result);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exceptionError($e->getMessage());
        }
    }

    public function createEmployee(ValidateBasicInfoRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->fingerprintService->storeData($request);

            $result = new SubmitFingerprintResource($data, 'Success Create Employee');
            DB::commit();
            return $this->respond($result);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exceptionError($e->getMessage());
        }
    }
   
}

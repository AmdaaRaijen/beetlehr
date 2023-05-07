<?php

namespace App\Services\Fingerprint;

use App\Models\Fingerprint;

class FingerPrintService 
{
    public function getData($request)
    {
        $search = $request->search;
        $filter_branch = $request->filter_branch;

        // Get company
        $query = Fingerprint::paginate(10);

        return $query;
    }  

    public function createData($request)
    {

        $inputs = $request->only(['name', 'serial_number', 'is_active']);
        $inputs['is_active'] = ($inputs['is_active'] == 'Yes') ? true : false;

        $fingerprint = Fingerprint::create($inputs);
        return $fingerprint;
    }

    public function deleteData($id)
    {
        $fingerprint = Fingerprint::findOrFail($id);
        $fingerprint->delete();

        return $fingerprint;
    }

    public function updateData($id,$request){
        $input = $request->only(['name','serial_number','is_active']);

        $query = Fingerprint::findOrFail($id);
        $query->update($input);

        return $query;
    }
}

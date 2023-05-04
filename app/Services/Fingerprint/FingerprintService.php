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

    public function deleteData($id)
    {
        $employee = Fingerprint::findOrFail($id);
        $employee->delete();

        return $employee;
    }
}

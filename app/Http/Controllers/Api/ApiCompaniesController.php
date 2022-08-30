<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiCompaniesController extends Controller
{
    /**
     * Return the contents of Company table in tabular form
     *
     */
    public function getCompaniesTabular()
    {
        $companies = Company::with('prefecture')->get();
        return response()->json($companies);
    }
}

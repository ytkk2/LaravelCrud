<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postcode;

class AddressController extends Controller
{
    public function getAddressByPostCode(Request $postCode)
    {
        $getRequest = $postCode->all()['id'];
        $getRequest = Postcode::where('postcode','=', $getRequest)->get();

        return response()->json($getRequest);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Postcode;
use App\Models\Area;
use App\Models\Prefecture;
use Config;

class CompanyController extends Controller
{
    private function getRoute() {
        return 'company';
    }

    public function index() {
        return view('backend.companies.index');
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $company = new Company();
        $prefectures = Prefecture::all();
        $company->form_action = $this->getRoute() . '.create';
        $company->page_title = 'Company Add Page';
        $company->page_type = 'create';
        return view('backend.companies.company', [
            'company' => $company,
            'prefectures' => $prefectures,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email:strict,spoof',
            'postcode' => 'required|numeric|digits:7',
            'prefecture_id' => 'required|string',
            'street_address' => 'nullable|string|max:255',
            'business_hour' => 'nullable|string',
            'regular_holiday' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'url' => 'nullable|url',
            'license_number' => 'nullable|numeric',
            'image' => 'file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
// store and name for posted image 
        $max_id = Company::max('id')+1;
        $path = $request->file('image')->storeAs('public/upload/files','Image_' .$max_id.'.png');
        $request->image = basename($path);
// Foreign key about prefecture_id
        $prefecture = $request->input('prefecture_id');
        $prefecture_id = Prefecture::where('display_name', '=', $prefecture)->first();

        Company::create([
            'name' =>$request->name,
            'email'=>$request->email,
            'postcode'=>$request->postcode,
            'prefecture_id'=>$prefecture_id['id'],
            'city'=>$request->city,
            'local'=>$request->local,
            'street_address'=>$request->street_address,
            'business_hour'=>$request->business_hour,
            'regular_holiday'=>$request->regular_holiday,
            'phone'=>$request->phone,
            'fax'=>$request->fax,
            'url'=>$request->url,
            'license_number'=>$request->license_number,
            'image' =>$request->image,
        ]);
         

            // Create is successful, back to list
        try{
            if ($request) {
                // Create is successful, back to list
                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_CREATE_MESSAGE'));
            } else {
                // Create is failed
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
            }
        }catch (Exception $e) {
                // Create is failed
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
            }

    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $company = Company::find($id);
        $prefectures = Prefecture::all();
        $company->form_action = $this->getRoute() . '.update';
        $company->page_title = 'Company Edit Page';
        // Add page type here to indicate that the company.blade.php is in 'edit' mode
        $company->page_type = 'edit';
        return view('backend.companies.editcompany', [
            'company' => $company,
            'prefectures' => $prefectures,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email:strict,spoof',
            'postcode' => 'required|numeric|digits:7',
            'prefecture_id' => 'required|string',
            'street_address' => 'nullable|string|max:255',
            'business_hour' => 'nullable|string',
            'regular_holiday' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'url' => 'nullable|url',
            'license_number' => 'nullable|numeric',
        ]);

        // Foreign key about prefecture_id
        $prefecture = $request->input('prefecture_id');
        if (is_integer($prefecture)){
            $prefecture = Prefecture::where('display_name', '=', $prefecture)->first();
        }
        $prefecture_id = Prefecture::where('display_name', '=', $prefecture)->first();

        Company::find($request->get('id'))
        ->update([
            'name' =>$request->name,
            'email'=>$request->email,
            'postcode'=>$request->postcode,
            'prefecture_id'=>$prefecture_id['id'],
            'city'=>$request->city,
            'local'=>$request->local,
            'street_address'=>$request->street_address,
            'business_hour'=>$request->business_hour,
            'regular_holiday'=>$request->regular_holiday,
            'phone'=>$request->phone,
            'fax'=>$request->fax,
            'url'=>$request->url,
            'license_number'=>$request->license_number,
        ]);
        try{
            if ($request) {
                // Create is successful, back to list
                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_CREATE_MESSAGE'));
            } else {
                // Create is failed
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
            }
        }catch (Exception $e) {
                // Create is failed
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
            }
}

    public function delete(Request $request) {
        try {
            // Get company by id
            $company = Company::find($request->get('id'));
            // Delete company
            $company->delete();
            // If delete is successful
            return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_DELETE_MESSAGE'));
        } catch (Exception $e) {
            // If delete is failed
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_DELETE_MESSAGE'));
        }
    }
}

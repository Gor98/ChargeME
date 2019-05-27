<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Company\Store;
use App\Http\Requests\Company\Destroy;
use App\Http\Requests\Company\Update;
use App\Http\Requests\Company\Show;
use App\Http\Requests\Company\Buy;
use App\Company;
use Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Show $request)
    {
        return view('company.index'); 
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Company $company)
    {
         return response()->json(['data' => $company->all()], 200);
    }
    
    /**
     * buy company.
     *
     * @return \Illuminate\Http\Response
     */
    public function buy(Buy $request)
    {

         try{
            // get base company
            $baseCompany = Company::findOrfail($request->baseCompanyId);

            // buy target company
            $baseCompany->child()->attach($request->targetCompanyId);
            // set target company as purchased
            Company::where('id', $request->targetCompanyId)->update(['is_child' => 1]);

        } catch(\Exaption $e) {
            return response()->json(['error' => [
                'message' => $e->getMessage()
            ]], $e->getCode());

        }

        return response()->json(['success' => [
                'message' => 'Company created!'
            ]], 201);
    
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Show $request)
    {
            return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, Company $company)
    {
        // get request data
        $data = $request->all();

        // store image 
        $data['image'] = $request->file('image')->store('public/company');
        $data['image'] = str_replace("public/","", $data['image']);

        try{
            // create company
            $company->create($data);
        } catch(\Exaption $e) {
            return response()->json(['error' => [
                'message' => $e->getMessage()
            ]], $e->getCode());

        }

        return response()->json(['success' => [
                'message' => 'Company created!'
            ]], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Show $request, $id)
    {        
        return view('company.show', ['id' => $id]);
    }

    public function single(Show $request, $id)
    {
        // get company with statoins
        $company = Company::findOrfail($id)->load('stations');

        // check if has childer then fetch its stations
        $company = $company->allStations($company);

        return response()->json(['success' => [
                'data' => $company
            ]], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {    
        $data = $request->all();

        try {
            // get company
            $company = Company::findOrfail($id);

            if ($request->image != 'null') {
                // update image in storage
                Storage::delete('/public/' . $company->image);
                $data['image'] = $request->file('image')->store('public/company');
                $data['image'] = str_replace("public/","", $data['image']);
            }else {
                unset($data['image']);
            }
  

            // update company 
            $company->update($data);
        } catch(\Exaption $e) {
            return response()->json(['error' => [
                'message' => $e->getMessage()
            ]], $e->getCode());

        }

        return response()->json(['success' => [
                'message' => 'Updated!',
                'data' => $$company = Company::findOrfail($id)
            ]], 200);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destroy $request, $id)
    {
        try {
            $company = Company::findOrfail($id);
            Storage::delete('/public/' . $company->image);
            
            if($company->child()->exists()){
                $company->child()->update(['is_child' => 0]);
            }
            $company->delete();
            return response()->json(204);
        } catch (\Exception $e) {
                 return response()->json(['error' => [
                'message' => $e->getMessage()
            ]], $e->getCode());
        }

    }

    public function tree($id)
    {

        $company = Company::findOrfail($id);
          $company = $company->hierarchically($company);
        dd($company);
    
    }

}

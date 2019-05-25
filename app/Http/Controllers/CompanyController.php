<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Company\Store;
use App\Http\Requests\Company\Destroy;
use App\Http\Requests\Company\Update;
use App\Company;
use Storage;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,  Company $company)
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
    public function show($id)
    {
        //
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
            $company->delete();
            return response()->json(204);
        } catch (\Exception $e) {
                 return response()->json(['error' => [
                'message' => $e->getMessage()
            ]], $e->getCode());
        }

    }
}

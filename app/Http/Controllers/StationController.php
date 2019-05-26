<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Station\Store;
use App\Http\Requests\Station\destroy;
use App\Station;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('station.index');
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Station $station)
    {
         return response()->json(['data' => $station->all()], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {

        try {
            Station::create($request->all());
        } catch(\Exaption $e) {
            return response()->json(['error' => [
                'message' => $e->getMessage()
            ]], $e->getCode());

        }

        return response()->json(['success' => [
            'message' => 'Created!'
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(destroy $request, $id)
    {
        try {
            Station::findOrfail($id)->delete();
            return response()->json(204);
        } catch (\Exception $e) {
                 return response()->json(['error' => [
                'message' => $e->getMessage()
            ]], $e->getCode());
        }
    }
}

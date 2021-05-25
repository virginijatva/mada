<?php

namespace App\Http\Controllers;

use App\Models\Master;
use Illuminate\Http\Request;
use Validator;

class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masters = Master::all();
        return view('master.index', ['masters' => $masters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //nepamirsti virsuje: use Validator;
        $validator = Validator::make($request->all(),
       [
           'master_name' => ['required', 'min:3', 'max:64'],
           'master_surname' => ['required', 'min:3', 'max:64'],
       ],
       );

       if ($validator->fails()) {  //tikriname, ar validatorius nesu feilino
           $request->flash();
           return redirect()->back()->withErrors($validator); //jei sufeilino, griztam
       }

        $master = new Master;
        $master->name = $request->master_name;
        $master->surname = $request->master_surname;
        $master->save();
        return redirect()->route('master.index')->with('success_message', 'New Master has been added to the list.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function show(Master $master)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function edit(Master $master)
    {
        return view('master.edit', ['master' => $master]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Master $master)
    {
        $validator = Validator::make($request->all(),
        [
            'master_name' => ['required', 'min:3', 'max:64'],
            'master_surname' => ['required', 'min:3', 'max:64'],
        ],
        [
            //galima apsirasyti savo pranesimus tokiu budu, jei nenorime defaultiniu:
            'master_name.min' => 'Master name has to be longer than 2 characters'
        ]
        );
 
        if ($validator->fails()) {  //tikriname, ar validatorius nesu feilino
            $request->flash();
            return redirect()->back()->withErrors($validator); //jei sufeilino, griztam
        }

        $master->name = $request->master_name;
        $master->surname = $request->master_surname;
        $master->save();
        return redirect()->route('master.index')->with('success_message', 'New Master has been editted successfully.');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function destroy(Master $master)
    {

        if ($master->masterOutfits->count()) {
            return redirect()->back()->with('info_message', 'This master cannot be deleted');
            return '<h1>You cannot delete this master because he has some outfits to complete</h1>';
        }
        $master->delete();
        return redirect()->route('master.index')->with('success_message', 'Master has been deleted from the list');;
    }
}

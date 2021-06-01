<?php

namespace App\Http\Controllers;

use App\Models\Master;
use Illuminate\Http\Request;
use Validator;
use View;

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

    public function list(Request $request)
    {

        if ($request->sort) {
            if ($request->sort == 'default' || $request->sort == 'name') {
                if ($request->order == 'default' || $request->order == 'asc') {
                    $masters = Master::orderBy('name')->get();
                } 
                else if ($request->order == 'desc') {
                    $masters = Master::orderBy('name', 'desc')->get();
                } 
                else {
                    $masters = Master::all(); //neturetu nutikti
                }
            } 
            else if ($request->sort == 'date') {
                if ($request->order == 'default' || $request->order == 'asc') {
                    $masters = Master::orderBy('updated_at')->get();
                } 
                else if ($request->order == 'desc') {
                    $masters = Master::orderBy('updated_at', 'desc')->get();
                } 
                else {
                    $masters = Master::all(); //neturetu nutikti
                }
            } 
            else {
                $masters = Master::all();
            }
        } 
        else {
            $masters = Master::all();
        }
    

        $listRender = View::make('master.list')->with(['masters' => $masters])->render();

        return response()->json([
            'helo' => 'Hello',
            'listHTML' => $listRender,
        ]);
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
        $validator = Validator::make(
            $request->all(),
            [
                'master_name' => ['required', 'min:3', 'max:64'],
                'master_surname' => ['required', 'min:3', 'max:64'],
                'master_portrait' => ['sometimes', 'mimes:jpg, gif, png'],
            ],
        );

        if ($validator->fails()) {  //tikriname, ar validatorius nesu feilino
            $request->flash();
            return redirect()->back()->withErrors($validator); //jei sufeilino, griztam
        }

        $master = new Master;

        if ($request->has('master_portrait')) { //tikrinam, ar uploadinom portreta

            $portrait = $request->file('master_portrait'); //jei taip, is request pasiimam ta file ir laravel mum sukuria jo objekta

            $imageName =
                $request->master_name . '-' .
                $request->master_surname . '-' .
                time() . '.' .
                $portrait->getClientOriginalExtension();

            $path = public_path() . '/portraits/'; //nustatom serverio vidini kelia

            $url = asset('portraits/' . $imageName); // url narsyklei isorinis kelias

            $portrait->move($path, $imageName); //is serverio tmp folderio perkeliam file'a i public folder

            $master->portrait = $url; //israugom url duombazej
        }


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
        $validator = Validator::make(
            $request->all(),
            [
                'master_name' => ['required', 'min:3', 'max:64'],
                'master_surname' => ['required', 'min:3', 'max:64'],
                'master_portrait' => ['sometimes', 'mimes:jpg, gif, png'],
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

        if ($request->has('master_portrait')) { //tikrinam, ar uploadinom portreta

            if ($master->portrait) {
                $imageName = explode('/', $master->portrait);
                $imageName = array_pop($imageName);
                $path = public_path() . '/portraits/' . $imageName;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $portrait = $request->file('master_portrait'); //jei taip, is request pasiimam ta file ir laravel mum sukuria jo objekta
            $imageName =
                $request->master_name . '-' .
                $request->master_surname . '-' .
                time() . '.' .
                $portrait->getClientOriginalExtension();
            $path = public_path() . '/portraits/'; //nustatom serverio vidini kelia
            $url = asset('portraits/' . $imageName); // url narsyklei isorinis kelias
            $portrait->move($path, $imageName); //is serverio tmp folderio perkeliam file'a i public folder
            $master->portrait = $url; //israugom url duombazej
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

        if ($master->portrait) {
            $imageName = explode('/', $master->portrait);
            $imageName = array_pop($imageName);
            $path = public_path() . '/portraits/' . $imageName;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $master->delete();
        return redirect()->route('master.index')->with('success_message', 'Master has been deleted from the list');;
    }
}

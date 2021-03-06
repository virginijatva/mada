<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\Outfit;
use Illuminate\Http\Request;
use Validator;
use PDF;

class OutfitController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $masters = Master::all();
        $master_id = 0;

        if ($request->master_id) {
            $master_id = $request->master_id;
            if ($request->sort) {
                if ('asc' == $request->order) {
                    if ('size' == $request->sort) {
                        $outfits =
                            Outfit::where('master_id', $request->master_id)
                            ->orderBy('size')
                            ->paginate(5)
                            ->withQueryString();
                        $order = 'asc';
                        $sort = 'size';
                    } elseif ('outfit' == $request->sort) {
                        $outfits =
                            Outfit::where('master_id', $request->master_id)
                            ->orderBy('type')
                            ->paginate(5)
                            ->withQueryString();
                        $order = 'asc';
                        $sort = 'outfit';
                    }
                }
                if ('desc' == $request->order) {
                    if ('size' == $request->sort) {
                        $outfits =
                            Outfit::where('master_id', $request->master_id)
                            ->orderBy('size', 'desc')
                            ->paginate(5)
                            ->withQueryString();
                        $order = 'desc';
                        $sort = 'size';
                    } elseif ('outfit' == $request->sort) {
                        $outfits =
                            Outfit::where('master_id', $request->master_id)
                            ->orderBy('type', 'desc')
                            ->paginate(5)
                            ->withQueryString();
                        $order = 'desc';
                        $sort = 'outfit';
                    }
                }
            } else {
                $outfits = Outfit::where('master_id', $request->master_id)->paginate(5)->withQueryString();
            }
        } else {
            if ($request->sort) {
                if ('asc' == $request->order) {
                    if ('size' == $request->sort) {
                        // $outfits = $outfits->sortBy('size');
                        $outfits = Outfit::orderBy('size')->paginate(10)->withQueryString();
                        $order = 'asc';
                        $sort = 'size';
                    } elseif ('outfit' == $request->sort) {
                        $outfits = Outfit::orderBy('type')->paginate(10)->withQueryString();
                        $order = 'asc';
                        $sort = 'outfit';
                    }
                }
                if ('desc' == $request->order) {
                    if ('size' == $request->sort) {
                        $outfits = Outfit::orderBy('size', 'desc')->paginate(10)->withQueryString();
                        $order = 'desc';
                        $sort = 'size';
                    } elseif ('outfit' == $request->sort) {
                        $outfits = Outfit::orderBy('type', 'desc')->paginate(10)->withQueryString();
                        $order = 'desc';
                        $sort = 'outfit';
                    }
                }
            } else {
                $outfits = Outfit::paginate(10);
            }
        }


        return view(
            'outfit.index',
            [
                'outfits' => $outfits,
                'masters' => $masters,
                'order' => $order ?? '',
                'sort' => $sort ?? '',
                'master_id' => $master_id,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $masters = Master::all();
        return view('outfit.create', ['masters' => $masters]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'outfit_type' => ['required', 'min:3', 'max:50'],
                'outfit_color' => ['required', 'min:2', 'max:20'],
                'outfit_size' => ['required', 'integer', 'min:1', 'max:100'],
                'outfit_about' => ['required'],
                'master_id' => ['required', 'integer', 'min:1'],
            ],
            [
                'master_id.min' => 'Please, select Master'
            ]
        );

        if ($validator->fails()) {  //tikriname, ar validatorius nesu feilino
            $request->flash();
            return redirect()->back()->withErrors($validator); //jei sufeilino, griztam
        }

        $outfit = new Outfit;
        $outfit->type = $request->outfit_type;
        $outfit->color = $request->outfit_color;
        $outfit->size = $request->outfit_size;
        $outfit->about = $request->outfit_about;
        $outfit->master_id = $request->master_id;
        $outfit->save();
        return redirect()->route('outfit.index')->with('success_message', 'New Outfit is created.');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outfit  $outfit
     * @return \Illuminate\Http\Response
     */
    public function show(Outfit $outfit)
    {
        return view('outfit.show', ['outfit' => $outfit]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outfit  $outfit
     * @return \Illuminate\Http\Response
     */
    public function edit(Outfit $outfit)
    {
        $masters = Master::all();
        return view('outfit.edit', ['outfit' => $outfit, 'masters' => $masters]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outfit  $outfit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Outfit $outfit)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'outfit_type' => ['required', 'min:3', 'max:50'],
                'outfit_color' => ['required', 'min:2', 'max:20'],
                'outfit_size' => ['required', 'integer', 'min:1', 'max:100'],
                'outfit_about' => ['required'],
                'master_id' => ['required', 'integer', 'min:1'],
            ],
            [
                'master_id.min' => 'Please, select Master'
            ]
        );

        if ($validator->fails()) {  //tikriname, ar validatorius nesu feilino
            $request->flash();
            return redirect()->back()->withErrors($validator); //jei sufeilino, griztam
        }

        $outfit->type = $request->outfit_type;
        $outfit->color = $request->outfit_color;
        $outfit->size = $request->outfit_size;
        $outfit->about = $request->outfit_about;
        $outfit->master_id = $request->master_id;
        $outfit->save();
        return redirect()->route('outfit.index')->with('success_message', 'Outfit is edited.');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outfit  $outfit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outfit $outfit)
    {
        $outfit->delete();
        return redirect()->route('outfit.index')->with('success_message', 'The Outfit is deleted.');;
    }

    public function pdf(Outfit $outfit)
    {
        $pdf = PDF::loadView('outfit.pdf', ['outfit' => $outfit]);
        return $pdf->download('outfit-id' . $outfit->id . '.pdf');
    }
}

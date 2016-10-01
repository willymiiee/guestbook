<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Guest;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = request()->get('page') > 1 ? request()->get('page') - 1 : 0;

        try {
            $guests = Guest::skip($page * 10)
                            ->take(10)
                            ->get();
        } catch (Exception $e) {
            return response()->json([
                'errors'    => $e->getMessage()
            ]);
        }

        return response()->json([
            'items' => $guests,
            'count' => count($guests)
        ]);
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
    public function store(Request $request)
    {
        if (!request()->has('name')) {
            return response()->json([
                'errors'    => 'Nama harus diisi!'
            ]);
        }

        $guest = new Guest;
        $guest->name = request()->get('name');
        $guest->save();

        return response()->json([
            'message'    => 'Data berhasil dimasukkan.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $guest = Guest::find($id);
        } catch (Exception $e) {
            return response()->json([
                'errors'    => $e->getMessage()
            ]);
        }

        return response()->json($guest);
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
        if (!request()->has('name')) {
            return response()->json([
                'errors'    => 'Nama harus diisi!'
            ]);
        }

        try {
            $guest = Guest::find($id);
        } catch (Exception $e) {
            return response()->json([
                'errors'    => $e->getMessage()
            ]);
        }

        $guest->name = request()->get('name');
        $guest->save();

        return response()->json([
            'message'    => 'Data berhasil diupdate.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $guest = Guest::find($id);
        } catch (Exception $e) {
            return response()->json([
                'errors'    => $e->getMessage()
            ]);
        }

        $guest->delete();

        return response()->json([
            'message'    => 'Data berhasil dihapus.'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Guest;
use Carbon\Carbon;

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
            $guests = Guest::orderBy('id', 'desc')
                            ->skip($page * 10)
                            ->take(10)
                            ->get();
            
            foreach ($guests as $key => $val) {
                $guests[$key]['created_date'] = $val['created_at']->format('d M Y H:i');
            }

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

        if ($guest) {
            $guest['created_date'] = $guest['created_at']->format('d M Y H:i');
            return response()->json($guest);
        } else {
            return response()->json([
                'errors'    => 'Tidak dapat menemukan data.'
            ]);
        }
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

        if ($guest) {
            $guest->name = request()->get('name');
            $guest->save();

            return response()->json([
                'message'    => 'Data berhasil diupdate.'
            ]);
        } else {
            return response()->json([
                'errors'    => 'Tidak dapat menemukan data.'
            ]);
        }
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

        if ($guest) {
            $guest->delete();

            return response()->json([
                'message'    => 'Data berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'errors'    => 'Tidak dapat menemukan data.'
            ]);
        }
    }
}

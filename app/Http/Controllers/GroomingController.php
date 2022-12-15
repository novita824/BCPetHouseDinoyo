<?php

namespace App\Http\Controllers;

use App\Models\Grooming;
use App\Models\Penitipan;
use Illuminate\Http\Request;
use Throwable;

class GroomingController extends Controller
{
    public function index(Request $request)
    {
        $pagination = 5;
        $grooming = Grooming::when($request->keyword, function ($query) use ($request) {
            $query
                ->where('id', 'like', "%{$request->keyword}%")
                ->orWhere('nama', 'like', "%{$request->keyword}%")
                ->orWhere('namahewan', 'like', "%{$request->keyword}%")
                ->orWhere('jenishewan', 'like', "%{$request->keyword}%")
                ->orWhere('umur', 'like', "%{$request->keyword}%")
                ->orWhere('alamat', 'like', "%{$request->keyword}%")
                ->orWhere('notelp', 'like', "%{$request->keyword}%")
                ->orWhere('tipegrooming', 'like', "%{$request->keyword}%")
                ->orWhere('sediapetcargo', 'like', "%{$request->keyword}%");
        })->orderBy('id')->paginate($pagination);

        return view('Grooming.groomingindex', compact('grooming'))
            ->with('i', (request()->input('page', 1) - 1) * $pagination);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $this->authorize('admin');
        $grooming = grooming::find($id);
        return view('Grooming.groominganedit', compact('grooming'));
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
        $request->validate([
            'nama' => 'required',
            'namahewan' => 'required',
            'jenishewan' => 'required',
            'umur' => 'required',
            'alamat' => 'required',
            'notelp' => 'required',
            'tipegrooming' => 'required',
            'sediapetcargo' => 'required',
        ]);
        $Grooming = Penitipan::where('id', $id)->first();
        $Grooming->update([
            'nama' => $request->get('nama'),
            'namahewan' => $request->get('namahewan'),
            'jenishewan' => $request->get('jenishewan'),
            'umur' => $request->get('umur'),
            'alamat' => $request->get('alamat'),
            'notelp' => $request->get('notelp'),
            'tipegrooming' => $request->get('tipegrooming'),
            'sediapetcargo' => $request->get('sediapetcargo')
        ]);

        return redirect()->route('grooming.index')
            ->with('success', 'Grooming Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('admin');
        try {
            Grooming::find($id)->delete();
            return redirect()->route('penitipan.index')
                ->with('success', 'Grooming Berhasil Dihapus');
        } catch (Throwable $error) {
            report($error);
            return redirect()->route('grooming.index')
                ->with('errors', 'Mohon Maaf Data Penitipan Belum Bisa Dihapus. Coba Lagi Nanti');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Penitipan;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Throwable;

class PenitipanController extends Controller
{
    public function index(Request $request)
    {
        $pagination = 5;
        $Penitipan = Penitipan::when($request->keyword, function ($query) use ($request) {
            $query
                ->where('Id', 'like', "%{$request->keyword}%")
                ->orWhere('namahewan', 'like', "%{$request->keyword}%")
                ->orWhere('namapemilik', 'like', "%{$request->keyword}%")
                ->orWhere('alamat', 'like', "%{$request->keyword}%")
                ->orWhere('sediapetcargo', 'like', "%{$request->keyword}%")
                ->orWhere('sediakandang', 'like', "%{$request->keyword}%")
                ->orWhere('tanggalpenitipan', 'like', "%{$request->keyword}%")
                ->orWhere('jenispaket', 'like', "%{$request->keyword}%")
                ->orWhere('berapakalimakan', 'like', "%{$request->keyword}%")
                ->orWhere('pakan', 'like', "%{$request->keyword}%")
                ->orWhere('riwayatvaksin', 'like', "%{$request->keyword}%")
                ->orWhere('kontak', 'like', "%{$request->keyword}%")
                ->orWhere('riwayatpenyakit', 'like', "%{$request->keyword}%");
        })->orderBy('Id')->paginate($pagination);

        return view('Penitipan.penitipanindex', compact('Penitipan'))
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
        $Penitipan = Penitipan::find($id);
        return view('Peniitipan.penitipanedit', compact('penitipan'));
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
        $Penitipan = Penitipan::where('id', $id)->first();
        $Penitipan->update([
            'nama' => $request->get('nama'),
            'namahewan' => $request->get('namahewan'),
            'jenishewan' => $request->get('jenishewan'),
            'umur' => $request->get('umur'),
            'alamat' => $request->get('alamat'),
            'notelp' => $request->get('notelp'),
            'tipegrooming' => $request->get('tipegrooming'),
            'sediapetcargo' => $request->get('sediapetcargo')
        ]);

        return redirect()->route('penitipan.index')
            ->with('success', 'Penitipan Berhasil Diupdate');
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
            Penitipan::find($id)->delete();
            return redirect()->route('penitipan.index')
                ->with('success', 'Penitipan Berhasil Dihapus');
        } catch (Throwable $error) {
            report($error);
            return redirect()->route('penitipan.index')
                ->with('errors', 'Mohon Maaf Data Penitipan Belum Bisa Dihapus. Coba Lagi Nanti');
        }
    }
}

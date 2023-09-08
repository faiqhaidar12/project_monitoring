<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $filterProgress = $request->input('filter_progress');
        $data = Project::where(function ($query) use ($keyword, $filterProgress) {
            $query->where('judul', 'LIKE', '%' . $keyword . '%')
                ->orWhere('project_leader', 'LIKE', '%' . $keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                ->orWhere('tanggal_mulai', 'LIKE', '%' . $keyword . '%')
                ->orWhere('tanggal_berakhir', 'LIKE', '%' . $keyword . '%')
                ->orWhere('nama_klien', 'LIKE', '%' . $keyword . '%');

            // Tambahkan filter progress jika ada nilai yang dipilih
            if (!empty($filterProgress)) {
                $query->orWhere(function ($subQuery) use ($filterProgress) {
                    if (in_array($filterProgress, ['<10', '<50', '<100'])) {
                        $subQuery->where('progress', '<', (int)str_replace('<', '', $filterProgress));
                    }
                });
            }
        })
            ->latest()
            ->orderBy('judul', 'asc')
            ->paginate(3);
        return view('FE.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('FE.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('judul', $request->judul);
        Session::flash('project_leader', $request->project_leader);
        Session::flash('nama_klien', $request->nama_klien);
        Session::flash('progress', $request->progress);
        Session::flash('email', $request->email);

        $request->validate([
            'judul' => 'required',
            'project_leader' => 'required',
            'tanggal_mulai' => 'date|required',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'nama_klien' => 'required',
            'email' => 'required|email|unique:projects,email',
            'progress' => 'required|numeric',
            'foto' => 'required|mimes:png,jpg,jpeg|max:2040',
        ], [
            'judul.required' => "Judul Harus diisi!!",
            'project_leader.required' => "Project Leader Harus diisi!!",
            'tanggal_mulai.required' => "Tanggal Mulai Harus diisi!!",
            'tanggal_berakhir.required' => "Tanggal Berakhir Harus diisi!!",
            'nama_klien.required' => "Nama Klien Harus diisi!!",
            'progress.required' => "Progress Harus diisi!!",
            'email.required' => "E-Mail Wajib diisi!!",
            'email.unique' => "E-Mail Sudah Dipakai!!",
            'foto.mimes' => "Jenis Foto Yang Anda Masukan Bukan Png,Jpg,Jpeg!!",
            'foto.required' => "Foto Wajib diinput!!",
            'foto.max' => "Ukuran File Yang Anda Masukan Terlalu Besar!!",
        ]);

        $foto_file = $request->file('foto');
        $foto_ekstensi = $foto_file->extension();
        $foto_nama = date('ymdhis') . "." . $foto_ekstensi;
        $foto_file->move(public_path('foto'), $foto_nama);

        $tanggalMulai = Carbon::parse($request->input('tanggal_mulai'));
        $tanggalBerakhir = Carbon::parse($request->input('tanggal_berakhir'));

        // Mengubah format ke "YYYY-MM-DD"
        $tanggalMulaiFormatted = $tanggalMulai->format('Y-m-d');
        $tanggalBerakhirFormatted = $tanggalBerakhir->format('Y-m-d');

        $data = [
            'judul' => $request->input('judul'),
            'project_leader' => $request->input('project_leader'),
            'tanggal_mulai' => $tanggalMulaiFormatted, // Menggunakan format baru
            'tanggal_berakhir' => $tanggalBerakhirFormatted,
            'nama_klien' => $request->input('nama_klien'),
            'progress' => $request->input('progress'),
            'email' => $request->input('email'),
            'foto' => $foto_nama,
        ];

        Project::create($data);
        return redirect('/project')->with('success', "Data Berhasil ditambahkan!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Project::where('id', $id)->first();
        return view('FE.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required',
            'project_leader' => 'required',
            'tanggal_mulai' => 'date|required',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'nama_klien' => 'required',
            'email' => 'required|email|unique:projects,email,' . $id, ',id',
            'progress' => 'required|numeric',
        ], [
            'judul.required' => "Judul Harus diisi!!",
            'project_leader.required' => "Project Leader Harus diisi!!",
            'tanggal_mulai.required' => "Tanggal Mulai Harus diisi!!",
            'tanggal_berakhir.required' => "Tanggal Berakhir Harus diisi!!",
            'nama_klien.required' => "Nama Klien Harus diisi!!",
            'email.required' => "E-Mail Wajib diisi!!",
            'email.unique' => "E-Mail Sudah Dipakai!!",
            'progress.required' => "Progress Harus diisi!!",
        ]);

        $tanggalMulai = Carbon::parse($request->input('tanggal_mulai'));
        $tanggalBerakhir = Carbon::parse($request->input('tanggal_berakhir'));

        // Mengubah format ke "YYYY-MM-DD"
        $tanggalMulaiFormatted = $tanggalMulai->format('Y-m-d');
        $tanggalBerakhirFormatted = $tanggalBerakhir->format('Y-m-d');

        $data = [
            'judul' => $request->input('judul'),
            'project_leader' => $request->input('project_leader'),
            'tanggal_mulai' => $tanggalMulaiFormatted, // Menggunakan format baru
            'tanggal_berakhir' => $tanggalBerakhirFormatted,
            'nama_klien' => $request->input('nama_klien'),
            'progress' => $request->input('progress'),
            'email' => $request->input('email'),
        ];

        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'mimes:png,jpg,jpeg|max:2040',
            ], [
                'foto.mimes' => "Jenis Foto Yang Anda Masukan Bukan Png,Jpg,Jpeg!!",
            ]);

            $foto_file = $request->file('foto');
            $foto_ekstensi = $foto_file->extension();
            $foto_nama = date('ymdhis') . "." . $foto_ekstensi;
            $foto_file->move(public_path('foto'), $foto_nama);

            $data_foto = Project::where('id', $id)->first();
            File::delete(public_path('foto') . '/' . $data_foto->foto);

            $data['foto'] = $foto_nama;
        }

        Project::where('id', $id)->update($data);
        return redirect('/project')->with('update', "Data Berhasil ditambahkan!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Project::where('id', $id)->first();
        File::delete(public_path('foto') . '/' . $data->foto);

        Project::where('id', $id)->delete();
        return redirect('/project')->with('success', 'Berhasil Hapus Data!');
    }
}

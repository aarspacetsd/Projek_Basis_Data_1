<?php

namespace App\Http\Livewire\Peminjam;

use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Livewire\Component;

class Keranjang extends Component
{
    public $tanggal_pinjam;

    protected $rules = [
        'tanggal_pinjam' => 'required|date|after_or_equal:today',
    ];

    public function hapus(Peminjaman $peminjaman, DetailPeminjaman $detail_peminjaman)
    {
        $detail_peminjaman->delete();

        // Hitung ulang setelah delete
        $sisa = $peminjaman->detail_peminjaman()->count();

        if ($sisa == 0) {
            session()->flash('sukses', 'Keranjang sekarang kosong');
            $this->emit('kurangiKeranjang');
            return;
        }

        session()->flash('sukses', 'Data berhasil dihapus');
        $this->emit('kurangiKeranjang');
    }

    public function hapusMasal()
    {
        $keranjang = Peminjaman::where('peminjam_id', auth()->user()->id)
            ->where('status', '!=', 3)
            ->latest()
            ->first();

        if ($keranjang) {
            foreach ($keranjang->detail_peminjaman as $detail_peminjaman) {
                $detail_peminjaman->delete();
            }

            // Jangan hapus $keranjang!
            session()->flash('sukses', 'Semua item dihapus, keranjang kosong');
            $this->emit('kurangiKeranjang');
        }

        return redirect('/'); // Diperbaiki: gunakan return
    }

    public function pinjam(Peminjaman $keranjang)
    {
        $this->validate();

        $keranjang->update([
            'status' => 1,
            'tanggal_pinjam' => $this->tanggal_pinjam,
            'tanggal_kembali' => Carbon::create($this->tanggal_pinjam)->addDays(10)
        ]);

        session()->flash('sukses', 'Buku berhasil dipinjam');
    }

    public function render()
    {
        $keranjang = Peminjaman::where('peminjam_id', auth()->user()->id)
            ->where('status', '!=', 3)
            ->latest()
            ->first();

        return view('livewire.peminjam.keranjang', [
            'keranjang' => $keranjang
        ]);
    }
}

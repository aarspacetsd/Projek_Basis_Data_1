<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Keranjang</h1>
        </div>
    </div>

    @include('admin-lte/flash')

    <!-- <div class="row">
        <div class="col-md-12 mb-4">
            <label for="tanggal_pinjam">Tanggal Peminjaman</label>
            <input wire:model="tanggal_pinjam" type="date" class="form-control" id="tanggal_pinjam">
            @error('tanggal_pinjam') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div> -->

    @if ($keranjang)
        <div class="row">
            <div class="col-md-12 mb-1">
                @if ($keranjang->tanggal_pinjam)
                    <strong>Tanggal Pinjam: {{$keranjang->tanggal_pinjam}}</strong>
                @else
                    <button wire:click="pinjam({{$keranjang->id}})" class="btn btn-sm btn-success">Pinjam</button>
                @endif
                <strong class="float-right">Kode Pinjam : {{$keranjang->kode_pinjam}}</strong>
            </div>
        </div>
    @else
        <div class="alert alert-info">Keranjang kosong.</div>
    @endif


    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Rak</th>
                        <th>Baris</th>
                        <th style="width: 1%;"></th> <!-- Kolom tombol hapus -->
                    </tr>
                </thead>
                <tbody>
                    @if ($keranjang && $keranjang->detail_peminjaman->count() > 0)
                        @foreach ($keranjang->detail_peminjaman as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->buku->judul}}</td>
                                <td>{{$item->buku->penulis}}</td>
                                <td>{{$item->buku->rak->rak}}</td>
                                <td>{{$item->buku->rak->baris}}</td>
                                <td class="text-center">
                                    <button wire:click="hapus({{$keranjang->id}}, {{$item->id}})" class="btn btn-sm btn-danger"
                                        title="Hapus">
                                        &times;
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center text-muted">Keranjang kosong</td>
                        </tr>
                    @endif

                </tbody>
            </table>

            <button wire:click="hapusMasal" class="btn btn-sm btn-danger">Hapus Masal</button>
            <button wire:click="pinjam_buku" class="btn btn-sm btn-primary">Pinjam</button>
        </div>
    </div>
</div>
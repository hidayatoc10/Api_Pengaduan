<h1>Selamat datang {{ auth()->user()->name }}</h1>
<a href="/logout">logout</a>
<p>
<p>
    <a href="/dashboard_admin"
        style="padding: 10px; background-color: blue; color: white; border-radius: 10px; text-decoration: none;">REFRESH</a>
<p>
    @if (session('berhasil'))
        <h3 style="color: blue;">Berhasil menghapus pengaduan</h3>
    @endif
    @if (session('berhasil_ubah'))
        <h3 style="color: blue;">Berhasil mengubah pengaduan</h3>
    @endif
<table cellpadding="10" cellspacing="0" border="1">
    <tr>
        <th>No</th>
        <th>Nama Pelapor</th>
        <th>Title</th>
        <th>Description</th>
        <th>Status Pengaduan</th>
        <th>Kategori Pengaduan</th>
        <th>Description Pengaduan</th>
        <th>Gambar Pelapor</th>
        <th>Gambar Petugas</th>
        <th>Tanggal Lapor</th>
        <th>Aksi</th>
    </tr>

    @foreach ($pengaduan as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->description }}</td>
            <td>
                <span
                    class="badge 
                @if ($item->status_pengaduan == 'PENDING') badge-warning
                @elseif($item->status_pengaduan == 'MENUNGGU') badge-secondary
                @elseif($item->status_pengaduan == 'SELESAI') badge-success
                @elseif($item->status_pengaduan == 'DITOLAK') badge-danger @endif">
                    {{ $item->status_pengaduan }}
                </span>
            </td>
            <td>{{ $item->kategori_pengaduan }}</td>
            <td>{{ $item->description_petugas }}</td>
            <td>
                <img src="{{ asset('storage/' . $item->image) }}" alt="Gambar Pengaduan" width="100">
            </td>
            <td>
                <img src="{{ asset('storage/' . $item->image_petugas) }}" alt="Gambar Petugas" width="100">
            </td>
            <td>{{ $item->tanggal_lapor }}</td>
            <td>
                <button class="btn btn-primary" data-toggle="modal"
                    data-target="#editModal{{ $item->id }}">Edit</button> |
                <a href="hapus/{{ $item->tanggal_lapor }}"
                    onclick="return confirm('Apakah ingin menghapus pengaduan {{ $item->user->name }}?')">Hapus</a>
            </td>
        </tr>
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Pengaduan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('edit_pengaduan', $item->title) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="description_petugas">Description Petugas</label>
                                <textarea name="description_petugas" class="form-control">{{ $item->description_petugas }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="status_pengaduan">Status Pengaduan</label>
                                <select name="status_pengaduan" class="form-control">
                                    <option value="PENDING"
                                        {{ $item->status_pengaduan == 'PENDING' ? 'selected' : '' }}>Pending</option>
                                    <option value="MENUNGGU"
                                        {{ $item->status_pengaduan == 'MENUNGGU' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="SELESAI"
                                        {{ $item->status_pengaduan == 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                                    <option value="DITOLAK"
                                        {{ $item->status_pengaduan == 'DITOLAK' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image_petugas">Gambar Feedback</label>
                                <input type="file" name="image_petugas" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</table>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

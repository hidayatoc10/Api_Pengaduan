@extends('../layouts/sidebar_admin')

@section('container')
    <style>
        .icon-large {
            font-size: 50px;
        }

        .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
    <link href="../vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="../vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <div class="main-content">
        <div class="title">
            Dashboard
        </div>
        <div class="content-wrapper">
            <div class="row same-height justify-content-start">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-primary">PENGADUAN</h6>
                                <h2>{{ $total }}</h2>
                            </div>
                            <i class="fas fa-file-upload text-primary icon-large"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-warning">PENGGUNA</h6>
                                <h2>{{ $user }}</h2>
                            </div>
                            <i class="fas fa-user-friends text-warning icon-large"></i>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h4 class="mb-3 mb-md-0">Pengaduan</h4>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-primary btn-sm" onclick="location.reload();">
                                    <i class="ti ti-reload"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table display nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelapor</th>
                                        <th>Title</th>
                                        <th>Status Pengaduan</th>
                                        <th>Tanggal Lapor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengaduan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td><span
                                                    class="badge 
                                            @if ($item->status_pengaduan == 'PENDING') badge-warning
                                            @elseif($item->status_pengaduan == 'MENUNGGU') badge-secondary
                                            @elseif($item->status_pengaduan == 'SELESAI') badge-success
                                            @elseif($item->status_pengaduan == 'DITOLAK') badge-danger @endif">
                                                    {{ $item->status_pengaduan }}
                                                </span>
                                            </td>
                                            <td>{{ $item->tanggal_lapor }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" title="Edit" data-bs-toggle="modal"
                                                    data-bs-target="#modal_edit_pengaduan_{{ $item->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success" title="View" data-bs-toggle="modal"
                                                    data-bs-target="#modal_view_pengaduan_{{ $item->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="modal_view_pengaduan_{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="modal_view_pengaduanLabel_{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content shadow-lg">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title d-flex align-items-center"
                                                            id="modal_view_pengaduanLabel_{{ $item->id }}">
                                                            <i class="fa fa-info-circle me-2"></i> Detail Pengaduan
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Layout 4 kolom -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-3 d-flex align-items-center mb-2">
                                                                <i class="fa fa-user text-primary me-2"></i>
                                                                <h6 class="mb-0"><strong>Nama Pelapor:</strong></h6>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p class="mb-0">{{ $item->user->name }}</p>
                                                            </div>
                                                            <div class="col-md-3 d-flex align-items-center mb-2">
                                                                <i class="fa fa-heading text-success me-2"></i>
                                                                <h6 class="mb-0"><strong>Judul Pengaduan:</strong></h6>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p class="mb-0">{{ $item->title }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-3 d-flex align-items-center">
                                                                <i class="fa fa-list-alt text-secondary me-2"></i>
                                                                <h6 class="mb-0"><strong>Kategori:</strong></h6>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p class="mb-0">{{ $item->kategori_pengaduan }}</p>
                                                            </div>
                                                            <div class="col-md-3 d-flex align-items-center">
                                                                <i class="fa fa-calendar-alt text-danger me-2"></i>
                                                                <h6 class="mb-0"><strong>Tanggal Lapor:</strong></h6>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p class="mb-0">{{ $item->tanggal_lapor }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-3 d-flex align-items-center">
                                                                <i class="fa fa-flag text-warning me-2"></i>
                                                                <h6 class="mb-0"><strong>Status:</strong></h6>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p class="mb-0">
                                                                    <span
                                                                        class="badge 
                                                                    @if ($item->status_pengaduan == 'PENDING') badge-warning
                                                                    @elseif($item->status_pengaduan == 'MENUNGGU') badge-secondary
                                                                    @elseif($item->status_pengaduan == 'SELESAI') badge-success
                                                                    @elseif($item->status_pengaduan == 'DITOLAK') badge-danger @endif">
                                                                        {{ $item->status_pengaduan }}
                                                                    </span>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-3 d-flex align-items-center">
                                                                <i class="fa fa-align-left text-info me-2"></i>
                                                                <h6 class="mb-0"><strong>Deskripsi:</strong></h6>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p class="mb-0">
                                                                    {{ $item->description ?? 'Tidak ada deskripsi' }}</p>
                                                            </div>
                                                        </div>

                                                        @if ($item->image)
                                                            <div class="row mb-3">
                                                                <div class="col-md-3 d-flex align-items-center">
                                                                    <i class="fa fa-image text-primary me-2"></i>
                                                                    <h6 class="mb-0"><strong>Gambar:</strong></h6>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <img src="{{ asset('storage/' . $item->image) }}"
                                                                        width="100" alt="Gambar Pengaduan"
                                                                        class="img-fluid rounded shadow-sm">
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($item->description_petugas)
                                                            <div class="row mb-3">
                                                                <div class="col-md-3 d-flex align-items-center">
                                                                    <i class="fa fa-comment text-success me-2"></i>
                                                                    <h6 class="mb-0"><strong>Feedback Petugas:</strong>
                                                                    </h6>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <p>{{ $item->description_petugas }}</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($item->updated_at)
                                                            <div class="row mb-3">
                                                                <div class="col-md-3 d-flex align-items-center">
                                                                    <i class="fa fa-comment text-success me-2"></i>
                                                                    <h6 class="mb-0"><strong>Update:</strong>
                                                                    </h6>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <p>{{ $item->updated_at }}</p>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($item->image_petugas)
                                                            <div class="row mb-3">
                                                                <div class="col-md-3 d-flex align-items-center">
                                                                    <i class="fa fa-image text-secondary me-2"></i>
                                                                    <h6 class="mb-0"><strong>Gambar Feedback:</strong>
                                                                    </h6>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <img src="{{ asset('storage/' . $item->image_petugas) }}"
                                                                        width="100" alt="Gambar Feedback"
                                                                        class="img-fluid rounded shadow-sm">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="fa fa-times me-2"></i> Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="modal_edit_pengaduan_{{ $item->id }}"
                                            tabindex="-1"
                                            aria-labelledby="modal_edit_pengaduanLabel_{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="modal_edit_pengaduanLabel_{{ $item->id }}">Feedback
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('edit_pengaduan', $item->title) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="description_petugas">Description
                                                                    Petugas</label>
                                                                <textarea name="description_petugas" class="form-control">{{ $item->description_petugas }}</textarea>
                                                                @error('description_petugas')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status_pengaduan">Status Pengaduan</label>
                                                                <select name="status_pengaduan" class="form-control">
                                                                    <option value="PENDING"
                                                                        {{ $item->status_pengaduan == 'PENDING' ? 'selected' : '' }}>
                                                                        Pending</option>
                                                                    <option value="MENUNGGU"
                                                                        {{ $item->status_pengaduan == 'MENUNGGU' ? 'selected' : '' }}>
                                                                        Menunggu</option>
                                                                    <option value="SELESAI"
                                                                        {{ $item->status_pengaduan == 'SELESAI' ? 'selected' : '' }}>
                                                                        Selesai</option>
                                                                    <option value="DITOLAK"
                                                                        {{ $item->status_pengaduan == 'DITOLAK' ? 'selected' : '' }}>
                                                                        Ditolak</option>
                                                                </select>
                                                                @error('status_pengaduan')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="image_petugas">Gambar Feedback</label>
                                                                <input type="file" name="image_petugas"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="settings">
        <div class="settings-icon-wrapper">
            <div class="settings-icon">
                <i class="ti ti-settings"></i>
            </div>
        </div>
        <div class="settings-content">
            <ul>
                <li class="fix-header">
                    <div class="fix-header-wrapper">
                        <div class="form-check form-switch lg">
                            <label class="form-check-label" for="settingsFixHeader">Fixed Header</label>
                            <input class="form-check-input toggle-settings" name="Header" type="checkbox"
                                id="settingsFixHeader">
                        </div>

                    </div>
                </li>
                <li class="fix-footer">
                    <div class="fix-footer-wrapper">
                        <div class="form-check form-switch lg">
                            <label class="form-check-label" for="settingsFixFooter">Fixed Footer</label>
                            <input class="form-check-input toggle-settings" name="Footer" type="checkbox"
                                id="settingsFixFooter">
                        </div>
                    </div>
                </li>
                <li>
                    <div class="theme-switch">
                        <label for="">Theme Color</label>
                        <div>
                            <div class="form-check form-check-inline lg">
                                <input class="form-check-input lg theme-color" type="radio" name="ThemeColor"
                                    id="light" value="light">
                                <label class="form-check-label" for="light">Light</label>
                            </div>
                            <div class="form-check form-check-inline lg">
                                <input class="form-check-input lg theme-color" type="radio" name="ThemeColor"
                                    id="dark" value="dark">
                                <label class="form-check-label" for="dark">Dark</label>
                            </div>

                        </div>
                    </div>
                </li>
                <li>
                    <div class="fix-footer-wrapper">
                        <div class="form-check form-switch lg">
                            <label class="form-check-label" for="settingsFixFooter">Collapse Sidebar</label>
                            <input class="form-check-input toggle-settings" name="Sidebar" type="checkbox"
                                id="settingsFixFooter">
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="../assets/js/pages/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script>
        Main.init()
    </script>
    <script>
        DataTable.init()
    </script>
@endsection
@section('scripts')
    @parent
    <script>
        @if (session('berhasil_ubah'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Berhasil mengubah pengaduan',
                confirmButtonText: 'Ok',
            });
        @endif
        @if (session('berhasil'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Berhasil menghapus pengaduan',
                confirmButtonText: 'Ok',
            });
        @endif
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.btn-danger').forEach(button => {
                button.addEventListener('click', function() {
                    const kelas = this.closest('tr').querySelector('td:nth-child(2)')
                        .innerText;
                    const created_at = this.closest('tr').querySelector('td:nth-child(5)')
                        .innerText;
                    Swal.fire({
                        title: "Peringatan",
                        text: `Apakah anda ingin menghapus pengaduan "${kelas}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                `/hapus/${encodeURIComponent(created_at)}`;
                        }
                    });
                });
            });
        });
    </script>
@endsection

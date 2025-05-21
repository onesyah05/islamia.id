@extends('admin.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Manajemen /</span> Ustadz
    </h4>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Total Ustadz Aktif</h5>
                            <small class="text-muted">Ustadz yang aktif mengajar</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded p-2">
                                <i class="bx bx-user-check bx-sm"></i>
                            </span>
                        </div>
                    </div>
                    <h3 class="card-text mb-2 mt-3">24</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Total Ustadz Tidak Aktif</h5>
                            <small class="text-muted">Ustadz yang tidak aktif</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-danger rounded p-2">
                                <i class="bx bx-user-x bx-sm"></i>
                            </span>
                        </div>
                    </div>
                    <h3 class="card-text mb-2 mt-3">8</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Ustadz Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Ustadz</h5>
            <button type="button" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i>
                Tambah Ustadz
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Ustadz Ahmad</h6>
                                        <small class="text-muted">@ahmad</small>
                                    </div>
                                </div>
                            </td>
                            <td>ahmad@example.com</td>
                            <td>081234567890</td>
                            <td><span class="badge bg-label-success">Aktif</span></td>
                            <td>12 Jan 2024</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

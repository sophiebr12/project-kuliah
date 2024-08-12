@extends('layout/template-main')

@section('container')
    <h1>Supplier Rekomendasi</h1>
    <hr>
    <form action="{{ route('index') }}" method="get">
        <div class="row">
            <div class="col-4">
                <h4 class="d-inline">Bobot :
                    <select class="form-control" name="bobot_id">
                        <option value="0">Pilih Bobot</option>
                        @foreach ($bobot as $key)
                            <option value="{{ $key->id }}">{{ $key->nama }}</option>
                        @endforeach
                        <!-- Tambahkan opsi lain sesuai kebutuhan -->
                    </select>
                </h4>
            </div>
            <div class="col-4">
                <h4 class="d-inline">Item :
                    <select class="form-control" name="item_id">
                        <option value="0">Pilih Item</option>
                        @foreach ($item as $key)
                            <option value="{{ $key->id }}">{{ $key->nama }}</option>
                        @endforeach
                    </select>
                </h4>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary w-100 h-100">Search</button>
            </div>
        </div>
        <hr>

        <div class="row mt-4">
            <div class="col-12 ">
                <h3 class="d-inline">Nama Bobot : <span class="badge bg-primary">{{ $data['bobotName'] }}</span></h3>
            </div>
        </div>


    </form>


    <hr>



    <div class="mt-4">
        <div class="row">
            <div class="col-2">
                <h4 class="fw-bold text-center">Harga</h4>
                <div class="text-center rounded-2 opacity-25 bg-secondary text-white p-4 ">
                    <h5 class="fs-2">
                        @if (isset($displayBobot))
                            {{ Str::substr($displayBobot['harga'], 0, 5) }}
                        @else
                            -
                        @endif
                    </h5>
                </div>
            </div>

            <div class="col-2">
                <h4 class="fw-bold text-center">Grade</h4>
                <div class="text-center rounded-2 opacity-25 bg-secondary text-white p-4 ">
                    <h5 class="fs-2">
                        @if (isset($displayBobot))
                            {{ Str::substr($displayBobot['grade'], 0, 5) }}
                        @else
                            -
                        @endif
                    </h5>
                </div>
            </div>

            <div class="col-2">
                <h4 class="fw-bold text-center">Lead Time</h4>
                <div class="text-center rounded-2 bg-secondary opacity-25 text-white p-4 ">
                    <h5 class="fs-2">
                        @if (isset($displayBobot))
                            {{ Str::substr($displayBobot['leadTime'], 0, 5) }}
                        @else
                            -
                        @endif
                    </h5>
                </div>
            </div>

            <div class="col-2">
                <h4 class="fw-bold text-center">Pembayaran</h4>
                <div class="text-center rounded-2 bg-secondary opacity-25 text-white p-4 ">
                    <h5 class="fs-2">
                        @if (isset($displayBobot))
                            {{ Str::substr($displayBobot['pembayaran'], 0, 5) }}
                        @else
                            -
                        @endif
                    </h5>
                </div>
            </div>

            <div class="col-4">
                <h4 class="fw-bold text-center">Control</h4>
                {{-- <a href="{{ route('view-supplier') }}">
                    <button class="btn btn-primary w-100">Tambah Supplier</button>
                </a> --}}
                <button class="btn btn-dark w-100 mt-2" data-bs-toggle="modal" data-bs-target="#createModal">Tambah
                    Bobot</button>
            </div>
        </div>
        <hr>
        <h3 class="d-inline mt-4">Nama Item : <span class="badge bg-primary">{{ $data['itemName'] }}</span></h3>
        <div class="table-responsive mt-4">
            <table class="table-hover table">
                <thead>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Lead Time</th>
                    <th>Harga</th>
                    <th>Grade</th>
                    <th>Pembayaran</th>
                    <th>Score</th>
                </thead>
                <tbody>
                    @if (isset($result))
                        @foreach ($result as $key)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $key['nama'] }}</td>
                                <td>{{ $key['leadTime'] }}</td>
                                <td>{{ $key['harga'] }}</td>
                                <td>{{ $key['grade'] }}</td>
                                <td>{{ $key['pembayaran'] }}
                                    @if ($key['pembayaran_text'] == 1)
                                        <span class="badge bg-danger">Cash</span>
                                    @elseif($key['pembayaran_text'] == 2)
                                        <span class="badge bg-danger">Tempo 1 Minggu</span>
                                    @elseif($key['pembayaran_text'] == 3)
                                        <span class="badge bg-success">Tempo 2 Minggu</span>
                                    @elseif($key['pembayaran_text'] == 4)
                                        <span class="badge bg-success">Tempo 4 Minggu</span>
                                    @endif
                                </td>
                                <td>{{ $key['score'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Bobot</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('create-bobot') }}" method="post">
                    @csrf
                    <div class="modal-body p-4">
                        <label for="">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" required class="form-control  mb-2"
                            placeholder="Nama Bobot...">
                        <label for="">Bobot Harga <span class="text-danger">*</span></label>
                        {{-- <input type="number" name="harga" required class="form-control mb-2" placeholder="0 - 100"> --}}
                        <select class="form-control" name="harga">
                            <option value="4">Murah</option>
                            <option value="3">Standart</option>
                            <option value="2">Mahal</option>
                            <option value="1">Sangat Mahal</option>
                        </select>
                        <label for="">Bobot Grade <span class="text-danger">*</span></label>
                        {{-- <input type="number" name="grade" required class="form-control mb-2" placeholder="0 - 100"> --}}
                        <select class="form-control" name="grade">
                            <option value="4">Excellent</option>
                            <option value="3">Good</option>
                            <option value="2">Moderate</option>
                            <option value="1">Awful</option>
                        </select>
                        <label for="">Bobot Lead Time <span class="text-danger">*</span></label>
                        <input type="number" name="leadTime" required class="form-control mb-2" placeholder="0 - 4">
                        <label for="">Bobot Tipe Pembayaran <span class="text-danger">*</span></label>
                        {{-- <input type="number" name="pembayaran" required class="form-control mb-2"
                            placeholder="0 - 100"> --}}
                        <select class="form-control" name="pembayaran">
                            <option value="4">Tempo 4 Minggu</option>
                            <option value="3">Tempo 2 Minggu</option>
                            <option value="2">Tempo 1 Minggu</option>
                            <option value="1">Cash</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

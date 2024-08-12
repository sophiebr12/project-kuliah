@extends('layout/template-main')

@section('container')
    <h1>Supplier List <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah</button></h1>
    <hr>

    <div class="table-responsive mt-4">
        <table class="table-hover table">
            <thead>
                <th>#</th>
                <th>Name</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th>Email</th>
                <th>Grade</th>
                <th>Lead Time</th>
                <th>Pembayaran</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($supplier as $key)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $key->nama }}</td>
                        <td>{{ $key->alamat }}</td>
                        <td>{{ $key->no_telp }}</td>
                        <td>{{ $key->email }}</td>
                        <td>
                            @if ($key->grade == 4)
                                Excellent
                            @elseif($key->grade == 3)
                                Good
                            @elseif($key->grade == 2)
                                Moderate
                            @else
                                Awful
                            @endif
                            ({{ $key->grade }}%)
                        </td>
                        <td>{{ $key->lead_time }}</td>
                        <td>
                            @if ($key->is_cash == 1)
                                <span class="badge bg-danger">Cash</span>
                            @elseif($key->is_cash == 2)
                                <span class="badge bg-danger">Tempo 1 Minggu</span>
                            @elseif($key->is_cash == 3)
                                <span class="badge bg-success">Tempo 2 Minggu</span>
                            @elseif($key->is_cash == 4)
                                <span class="badge bg-success">Tempo 4 Minggu</span>
                            @endif
                        </td>
                        <td>

                            <button class="btn btn-primary"
                                onclick="changeValue({{ $key->id }}, '{{ $key->nama }}', '{{ $key->alamat }}', '{{ $key->no_telp }}', '{{ $key->email }}', {{ $key->grade }}, {{ $key->lead_time }})"
                                data-bs-toggle="modal" data-bs-target="#updateModal">U</button>
                            <form action="{{ route('delete-supplier', ['id' => $key->id]) }}" method="post"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-danger " type="submit">X</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Supplier</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('create-supplier') }}" method="post">
                    @csrf
                    <div class="modal-body p-4">
                        <h6>Data Info</h6>
                        <label for="">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" required class="form-control" placeholder="Nama Supplier...">

                        <label for="" class="mt-2">Alamat</label>
                        <input type="text" name="alamat" class="form-control" placeholder="alamat">
                        <label for="" class="mt-2">No Telp</label>
                        <input type="text" name="no_telp" class="form-control" placeholder="no telp">
                        <label for="" class="mt-2">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="email">
                        <label for="" class="mt-2">Grade <span class="text-danger">*</span></label>
                        <input type="number" name="grade" required class="form-control" placeholder="0 - 100">
                        <label for="" class="mt-2">Lead Time <span class="text-danger">*</span></label>
                        <input type="number" name="lead_time" required class="form-control" placeholder="0">
                        <label for="" class="mt-2">Tipe Pembayaran <span class="text-danger">*</span></label>
                        <select class="form-control" name="pembayaran">
                            <option value="0">Cash</option>
                            <option value="1">Kredit</option>
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

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Supplier</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('create-supplier') }}" method="post">
                    @csrf
                    <div class="modal-body p-4">
                        <h6>Data Info</h6>

                        <input type="hidden" name="id" id="uId" value="">

                        <label for="">Nama <span class="text-danger">*</span></label>
                        <input type="text" id="uNama" name="nama" required class="form-control"
                            placeholder="Nama Supplier...">

                        <label for="" class="mt-2">Alamat</label>
                        <input type="text" id="uAlamat" name="alamat" class="form-control" placeholder="alamat">
                        <label for="" class="mt-2">No Telp</label>
                        <input type="text" id="uNoTelp" name="no_telp" class="form-control" placeholder="no telp">
                        <label for="" class="mt-2">Email</label>
                        <input type="text" id="uEmail" name="email" class="form-control" placeholder="email">
                        <label for="" class="mt-2">Grade <span class="text-danger">*</span></label>
                        {{-- <input type="number" id="uGrade" name="grade" required class="form-control"
                            placeholder="0 - 100"> --}}
                        <select class="form-control" name="grade">
                            <option value="4">Excellent</option>
                            <option value="3">Good</option>
                            <option value="2">Moderate</option>
                            <option value="1">Awful</option>
                        </select>
                        <label for="" class="mt-2">Lead Time <span class="text-danger">*</span></label>
                        <input type="number" id="uLeadTime" name="lead_time" required class="form-control"
                            placeholder="0">
                        <label for="" class="mt-2">Tipe Pembayaran <span class="text-danger">*</span></label>
                        <select class="form-control" name="pembayaran">
                            <option value="0">Cash</option>
                            <option value="1">Kredit</option>
                        </select>

                        <button type="submit" class="btn btn-primary mt-4 w-100">Save</button>
                </form>
                <hr>
                <h6>Item Supplier</h6>
                <form action="{{ route('create-item-supplier') }}" class="p-2" method="post">
                    @csrf
                    <input type="hidden" name="id" id="uiId" value="">
                    <div class="row">
                        <label for="">Nama Item</label>
                        <select class="form-control" name="itemId">
                            @foreach ($item as $key)
                                <option value="{{ $key->id }}">{{ $key->nama }}</option>
                            @endforeach
                        </select>
                        <label for="" class="mt-2">Harga</label>
                        <input type="number" name="harga" required class="form-control" value="0">
                    </div>
                    <hr>
                    <button class="btn btn-primary btn-add-item mt-2 w-100" type="submit">Tambah</button>
                </form>
                <hr>
                List Item
                <div class="">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <th>#</th>
                                <th>nama</th>
                                <th>harga</th>
                                <th>action</th>
                            </thead>
                            <tbody class="container-item">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>

    <script>
        function changeValue(id, nama, alamat, noTelp, email, grade, leadTime) {
            console.log(nama, alamat, noTelp, email, grade, leadTime);
            $('#uiId').val(id);
            $('#uId').val(id);
            $('#uNama').val(nama);
            $('#uAlamat').val(alamat);
            $('#uNoTelp').val(noTelp);
            $('#uEmail').val(email);
            $('#uGrade').val(grade);
            $('#uLeadTime').val(leadTime);

            $.ajax({
                url: "{{ route('get-item-supplier') }}", // Gantilah dengan URL yang sesuai
                data: {
                    id: id
                },
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    // Bersihkan isi container-item
                    $('.container-item').empty();

                    // Tambahkan data ke dalam container-item
                    $.each(data, function(index, item) {
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + item.nama + '</td>' +
                            '<td>' + item.harga + '</td>' +
                            `<td><a href="/delete-item-supplier?id=${item.item_id}"><button type="button" class='btn btn-danger btn-delete-item'>Delete</button></a></td>` +
                            '</tr>';
                        $('.container-item').append(row);
                        console.log(item.item_id);
                    });
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });

        }
    </script>
@endsection

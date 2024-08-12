@extends('layout/template-main')

@section('container')
    <h1>Item List <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah</button></h1>
    <hr>

    <div class="table-responsive mt-4">
        <table class="table-hover table">
            <thead>
                <th>#</th>
                <th>Name</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($item as $key)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $key->nama }}</td>
                        <td><button class="btn btn-dark" onclick="changeValue({{ $key->id }}, '{{ $key->nama }}')"
                                data-bs-toggle="modal" data-bs-target="#updateModal">E</button>
                            <form action="{{ route('delete-item', ['id' => $key->id]) }}" method="post" class="d-inline">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Item</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('create-item') }}" method="post">
                    @csrf
                    <div class="modal-body p-4">
                        <label for="">Nama</label>
                        <input type="text" name="nama" required class="form-control" placeholder="Nama Item...">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Item</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update-item') }}" method="post">
                    @csrf
                    <div class="modal-body p-4">
                        <label for="">Nama</label>
                        <input type="hidden" id="modalId" name="id" value="0">
                        <input type="text" id="modalName" name="nama" required class="form-control"
                            placeholder="Nama Item...">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function changeValue(id, nama) {
            console.log(nama);
            $('#modalId').val(id);
            $('#modalName').val(nama);
        }
    </script>
@endsection

@extends('admin.layout')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <button class="btn btn-primary btn-circle btn-sm" id="addNewItem"><i class="fas fa-search"></i></button>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>image</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>image</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($news as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->content }}</td>
                            <td>{{ $item->files }}</td>
                            <td class="text-right">


                                <button class="btn btn-info btn-edit" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-description="{{ $item->description }}">Edit</button>
                                <button class="btn btn-danger btn-delete" data-id="{{ $item->id }}">Delete</button>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@extends('admin.news.add')

@endsection
@section('extrajs')
<!-- Page level plugins -->
<script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>

<script>
    // Script untuk menangani modal
    $(document).ready(function() {
        // Menampilkan modal untuk menambah item baru
        $('#addNewItem').click(function() {
            $('#itemModal').modal('show');
            $('#itemForm')[0].reset();

            var file = $(this).closest('tr').find('td:eq(2)').text(); // Mendapatkan nilai kolom ketiga (nama file)
            // Menampilkan tautan file jika ada
            if (file) {
                // Periksa apakah file adalah gambar atau bukan
                if (file.endsWith('.jpg') || file.endsWith('.jpeg') || file.endsWith('.png') || file.endsWith('.gif')) {
                    // Jika file adalah gambar, tampilkan gambar
                    $('#fileLink').html('<img src="{{ asset("news_images/") }}' + '/' + file + '" alt="File Image">');
                } else {
                    // Jika file bukan gambar, tampilkan tautan unduh
                    $('#fileLink').html('<a href="' + file + '" download>' + file + '</a>');
                }
            } else {
                $('#fileLink').html('');
            }
        });

        // Menampilkan modal untuk mengedit item
        $('.btn-edit').click(function() {
            $('#itemModal').modal('show');
            // Mengisi nilai input dengan data dari tombol yang diklik
            var itemId = $(this).data('id');
            var title = $(this).closest('tr').find('td:eq(0)').text(); // Mendapatkan nilai kolom pertama (judul)
            var content = $(this).closest('tr').find('td:eq(1)').text(); // Mendapatkan nilai kolom kedua (konten)
            var file = $(this).closest('tr').find('td:eq(2)').text(); // Mendapatkan nilai kolom ketiga (nama file)

            console.log(file)
            $('#itemId').val(itemId);
            $('#title').val(title);
            $('#content').val(content);

            // Menampilkan tautan file jika ada
            if (file) {
                // Periksa apakah file adalah gambar atau bukan
                if (file.endsWith('.jpg') || file.endsWith('.jpeg') || file.endsWith('.png') || file.endsWith('.gif')) {
                    // Jika file adalah gambar, tampilkan gambar
                    $('#fileLink').html('<img src="{{ asset("news_images/") }}' + '/' + file + '" alt="File Image">');
                } else {
                    // Jika file bukan gambar, tampilkan tautan unduh
                    $('#fileLink').html('<a href="' + file + '" download>' + file + '</a>');
                }
            } else {
                $('#fileLink').html('');
            }


        });

        // Menyimpan item (Tambah/Edit)
        $('#saveItem').click(function() {
            var formData = new FormData($('#itemForm')[0]); // Membuat objek FormData untuk mengirim data formulir, termasuk file
            $.ajax({
                type: 'POST',
                url: '/news',
                data: formData, // Menggunakan objek FormData untuk mengirim data formulir
                contentType: false, // Tidak mengatur tipe konten secara otomatis
                processData: false, // Tidak memproses data secara otomatis
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        // Menghapus item
        $('.btn-delete').click(function() {
            if (confirm('Are you sure you want to delete this item?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/news/' + $(this).data('id'),
                    data: $('#itemForm').serialize(),
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
@endsection
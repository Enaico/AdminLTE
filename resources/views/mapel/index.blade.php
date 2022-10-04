@extends ('layout.app')

@section('title')
    Mapel
@endsection

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Mapel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Daftar Mapel</li>
                    </ol>
                </div>
            </div>
        </div>
    </section> 

    <section class="content"> 
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Mapel</h3>
                <div class="card-tools">
                    <button type="button" onclick="addForm('{{route('mapel.store')}}')" class="btn btn-tool">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover-text-nowrap" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>                   
                        @foreach ( $mapel as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>                      
                            </tr>
                        @endforeach         
                </table>
            </div>
        </div>
    </section> 
@includeIf('mapel.form')
@endsection

@push ('script')
    <script>

        let table;

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autowidth: false,
                ajax: {
                    url: '{{ route('mapel.data') }}'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'nama'},
                    {data: 'aksi'}
                ]
            });
        })



        $('#modalForm').on('submit', function(e){
            if(! e.preventDefault()){
                $.post($('#modalForm form').attr('action'), $('#modalForm form').serialize())
                .done((response) => {
                    $('#modalForm').modal('hide');
                    table.ajax.reload();
                    iziToast.success({
                        title: 'Sukses',
                        message: 'Data berhasil disimpan',
                        position: 'topRight'
                    })
                })
                .fail((errors) => {
                    iziToast.error({
                        title: 'Gagal',
                        message: 'Data gagal disimpan',
                        position: 'topRight'
                    })
                    return;
                })
            }
        })
                
        
        

        function addForm(url){
            $('#modalForm').modal('show');
            $('#modalForm .modal-title').text('Tambah Data Mapel');

            $('#modalForm form')[0].reset();
            $('#modalForm form').attr('action', url);
            $('#modalForm [name=_method]').val('post');
            table.ajax.reload();
        }
        function editData(url){
            $('#modalForm').modal('show');
            $('#modalForm .modal-title').text('Edit Data Mapel');

            $('#modalForm form')[0].reset();
            $('#modalForm form').attr('action', url);
            $('#modalForm [name=_method]').val('put');

            $.get(url)
                .done((response) => {
                    $('#modalForm [name=nama]').val(response.nama);
                    // console.log(response.name);
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data');
                    return; 
                })
        }

        function deleteData(url){
            swal({
                title: "Yakinzz?",
                text: "OK=HAPUSS HUHHUHU",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    swal({
                        title: "Sukses",
                        text: "Berhasil aborsi data!?!?!",
                        icon: "success",
                    });
                    return;
                })
                .fail((errors) => {
                    swal({
                        title: "Sukses",
                        text: "Berhasil aborsi data!?!?!",
                        icon: "error",
                    });
                    return;
        
                });

                table.ajax.reload();
                }         
            });        
        }      
        
    </script>
@endpush 
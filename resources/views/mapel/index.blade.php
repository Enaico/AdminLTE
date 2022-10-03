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
                            <table class="table table-hover-text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $mapel as $item )
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>
                                                <button type="buttton"onclick="editData('{{route('mapel.update', $item->id)}}')" class="btn btn-flat btn-sm btn-warning"><i class="fa fa-edit"></i></button>
                                                <button type="buttton"onclick="deleteData('{{route('mapel.destroy', $item->id)}}')" class="btn btn-flat btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
                    url: '{{'route('mapel.data')'}}'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'nama'},
                ]
            });
        })



        $('#modalForm').on('submit', function(e){
            if(! e.preventDefault()){
                $.post($('#modalForm form').attr('action'), $('#modalForm form').serialize())
                .done((response) => {
                    $('#modalForm').modal('hide');
                    tabel.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menyimpant Data');
                    return;
                })
            }
        })
                
        
        

        function addForm(url){
            $('#modalForm').modal('show');
            $('#modalForm .modal-title').text('Tambah Data Mapel');

            $('#modalForm form').attr('action', url);
            $('#modalForm [name=_method]').val('post');
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
            if(confirm('Yakin akan menghapus data?')){
                $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    alert('Data berhasil di hapus');
                    return;
                })
                .fail((errors) => {
                    alert('Data gagal di hapus!');
                    return;
                })
            } 
        }
    </script>
@endpush 
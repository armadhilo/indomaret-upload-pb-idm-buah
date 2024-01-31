@extends('master')
@section('title')
    <h1 class="pagetitle">Upload PB IDM</h1>
@endsection

@section('css')
<style>
    .detail{
        margin-bottom: 40px;
        margin-left: 30px;
    }

    .detail-action > *{
        width: unset;
        display: inline-block;
    }

    .btn-warning{
        box-shadow: 0 2px 6px #ffc473;
        background: #ffa426;
        color: white;
        font-size: 15px;
    }

    .btn-warning:hover{
        color: white;
    }

    .table tbody tr.deactive td{
        background-color: #ffb6c19e;
    }

    .btn-success{
        box-shadow: 0 2px 6px #81d694;
        background-color: #47c363;
        border-color: #47c363;
        color: white;
        font-size: 13px;
    }

    .table tbody tr.deactive td{
        background-color: #ffb6c19e;
    }

    .select-r td {
        background-color: #566cfb !important;
        color: white!important;
    }

    .header-input{
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header-input label{
        white-space: nowrap;
        display: block;
        width: 210px;
        background: #bb7f12;
        color: white;
        padding: 7px 10px;
        text-align: center;
        border-radius: 5px;
    }

    #header_tb{
        background: #6E214A;
        padding: 6px;
        color: white;
        margin-bottom: 15px;
        text-align: center;
        border: 2px groove lightgray;
    }

    #header_tb h5{
        font-size: 1rem;
        font-weight: bold;
    }


    .header-input input{
        width: 40%;
    }

    #tb_header tbody tr{
        cursor: pointer;    
    }

    #loading_datatable{
        opacity: .85!important;
    }
</style>
@endsection

@section('content')
    <script src="{{ url('js/home.js?time=') . rand() }}"></script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="header">
                            <div class="w-100" id="header_tb">
                                <h5>F3 - TARIK DATA CSV &nbsp;|&nbsp; F6 - TARIK ALOKASI &nbsp;|&nbsp; F8 - UPLOAD BUAH IMPORT &nbsp;|&nbsp; F9 - UPLOAD BUAH LOKAL &nbsp;|&nbsp; F10 - UPLOAD CHILL FOOD</h5>
                            </div>
                            <div class="form-group header-input">
                                <label for="csv_input">PATH FILE PBBH*.CSV</label>
                                <input type="file" id="csv_input" name="encrypted_csv" multiple webkitdirectory directory class="form-control" style="height: 47px;">
                            </div>
                        </div>
                        <div class="body">
                            <div class="position-relative">
                                <table class="table table-striped table-hover datatable-dark-primary table-center" id="tb_header" style="margin-top: 20px">
                                    <thead>
                                        <tr>
                                            <th>JENIS</th>
                                            <th>NO. PB</th>
                                            <th>TGL PB</th>
                                            <th>TOKO</th>
                                            <th>ITEM</th>
                                            <th>RUPIAH</th>
                                            <th>NAMA FILE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <button class="btn btn-lg btn-primary d-none" id="loading_datatable" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" type="button" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
    
                            </div>
    
                            <div class="position-relative mt-5">
                                <table class="table table-striped table-hover table-center datatable-dark-primary" id="tb_detail" style="margin-top: 20px">
                                    <thead>
                                        <tr>
                                            <th>PLU</th>
                                            <th>TOKO</th>
                                            <th>DESKRIPSI</th>
                                            <th>QTY</th>
                                            <th>RPH</th>
                                            <th>STOCK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <button class="btn btn-lg btn-primary d-none" id="loading_datatable_detail" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" type="button" disabled>
                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('page-script')

    <script>
        let tb_header;
        let tb_detail;
        let selectedRowData;
        function initializeDatatables(){
            tb_header = $('#tb_header').DataTable({
                processing: true,
                ajax: {
                    url: '/upload-pb-idm/datatablesHeader',
                    type: 'GET'
                },
                language: {
                    emptyTable: "<div class='datatable-no-data' style='color: #ababab'>Tidak Ada Data</div>",
                },
                columns: [
                    { data: 'jenis'},
                    { data: 'nopb'},
                    { data: 'tglpb'},
                    { data: 'toko'},
                    { data: 'plu'},
                    { data: 'rupiah'},
                    { data: 'nama_file'},
                ],
                columnDefs: [
                    { className: 'text-center-vh', targets: '_all' },
                ],
                rowCallback: function(row, data){
                    $(row).dblclick(function() {
                        $('#tb_header tbody tr').removeClass('select-r');
                        $(this).addClass("select-r");
                        selectedRowData = data;
                        showDatatableDetail(data.toko);
                    });
                },
            });

            tb_detail = $('#tb_detail').DataTable({
                language: {
                    emptyTable: "<div class='datatable-no-data' style='color: #ababab'>Tidak Ada Detail</div>",
                },
                columns: [
                    { data: 'plu'},
                    { data: 'toko'},
                    { data: 'desk'},
                    { data: 'qty'},
                    { data: 'rph'},
                    { data: 'stock'},
                ],
                columnDefs: [
                    { className: 'text-center-vh', targets: '_all' },
                ],
                data: [],
                rowCallback: function(row, data){
                },
            });

        }
        $(document).ready(function(){
            initializeDatatables();
        });

        function uploadCSV(){
            let input = $('#csv_input');
            if(input.val() === null || input.val() === ''){
                Swal.fire({
                    text: "Mohon Isi File Path CSV Terlebih Dahulu",
                    icon: "error"
                });
                return;
            }
            let files = input[0].files;
            let formData = new FormData();
            for (var i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }                
            $("#modal_loading").modal("show");
            $.ajax({
                url: "/upload-pb-idm/action/upload-csv",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    if(response.code === 200){
                        Swal.fire({
                            text: response.message,
                            icon: "success"
                        }).then(function(){
                            showDatatablesHead();
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    Swal.fire({
                        text: (jqXHR.responseJSON && jqXHR.responseJSON.code === 400)
                            ? jqXHR.responseJSON.message
                            : "Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")",
                        icon: "error"
                    });
                }
            });
        };

        $(document).keydown(function(e) {
            // Check if the pressed key is F3 (key code 114)
            if (e.which === 114 || e.keyCode === 114) {
            // Call your function here
                e.preventDefault();
                uploadCSV();
            }

        });
    </script>
    @endpush
@endsection


@extends('master')
@section('title')
    <h1 class="pagetitle">LIST PLU HADIAH PERISHABLE</h1>
@endsection

@section('css')
<style>
    .header-form{
        height: 35px;
        display: inline-flex;
        gap: 14px;
    }

    .header-label{
        white-space: nowrap;
        display: flex;
        justify-content: end;
        align-items: center;
        width: 115px;
        background: #dfdfdf;
        color: black;
        padding-right: 8px;
        font-weight: bold;
        height: 100%;
        margin: 0;
    }

    .select-r2 td {
        background-color: #566cfb !important;
        color: white!important;
    }

    #tb_hadiah tbody tr {
        cursor: pointer;
    }

    #tb tbody tr {
        cursor: pointer;
    }

    #button_insert{
        width: 80%;
        font-weight: bold;
        margin: 0 auto;
        font-size: 2.2rem;
        height: 100%;
    }

    .header-tb{
        background: #6E214A;
        padding: 8px;
        color: white;
        text-align: center;
        border: 2px groove lightgray;
    }
    
    .dataTables_wrapper .row:first-child .col-sm-12:first-child{
        display: none;
    }
    div.dataTables_wrapper div.dataTables_filter{
        text-align: left;
    }

    @media(max-width: 1500px){
        #button_insert{
            font-size: 1.7rem;
            width: 100%;
        }
    }

    @media(max-width: 1100px){
        #button_insert{
            font-size: 1.2rem;
        }
    }

</style>
@endsection

@section('content')
    <script src="{{ url('js/home.js?time=') . rand() }}"></script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-5">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover datatable-dark-primary w-100" id="tb">
                                        <thead>
                                            <tr>
                                                <th>PRDCD</th>
                                                <th>DESKRIPSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <button class="btn btn-primary d-flex justify-content-center align-items-center" id="button_insert">INSERT</button>
                            </div>
                            <div class="col-12 col-md-5">
                                <h5 class="header-tb">LIST PLU HADIAH PERISHABLE</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover datatable-dark-primary w-100" id="tb_hadiah">
                                        <thead>
                                            <tr>
                                                <th>PRDCD</th>
                                                <th>DESKRIPSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('page-script')
    <script>
        let tb;
        let tb_hadiah;
        let selectedRowData;
        let selectedRowData2;
        $(document).ready(function() {
            tb = $('#tb').DataTable({
                processing: true,
                ajax: {
                    url: '/plu-hadiah/datatables-master',
                    type: 'GET'
                },
                columnDefs: [
                    { className: 'text-center', targets: [0] },
                ],
                order: [],
                "paging": false, 
                "scrollY": "calc(100vh - 300px)",
                "scrollCollapse": true,
                columns: [
                    // { data: 'DT_RowIndex',searchable: false,orderable: false },
                    { data: 'prdcd' },
                    { data: 'desk' },
                ],
                rowCallback: function(row, data){
                    $(row).on('click', function() {
                        $('#tb tbody tr').removeClass('select-r');
                        $(this).toggleClass("select-r");
                        selectedRowData = data;
                    });
                }
            });
            tb_hadiah = $('#tb_hadiah').DataTable({
                processing: true,
                ajax: {
                    url: '/plu-hadiah/datatables-hadiah',
                    type: 'GET'
                },
                columnDefs: [
                    { className: 'text-center', targets: [0] },
                ],
                order: [],
                "paging": false, 
                "scrollY": "calc(100vh - 300px)",
                "scrollCollapse": true,
                columns: [
                    // { data: 'DT_RowIndex',searchable: false,orderable: false },
                    { data: 'prdcd' },
                    { data: 'desk' },
                ],
                rowCallback: function(row, data){
                    $(row).on('click', function() {
                        $('#tb_hadiah tbody tr').removeClass('select-r2');
                        $(this).toggleClass("select-r2");
                        selectedRowData2 = data;
                    });
                }
            });
        });

        $(document).on('click', function(event) {
            // Check if the clicked element is not a descendant of the table
            if (!$(event.target).closest('#tb tbody tr').length && !$(event.target).closest('#button_insert').length && $('#tb tbody tr').hasClass('select-r')) {
                // Reset selectedRowData and remove 'select-r' class
                $('#tb tbody tr').removeClass('select-r');
                selectedRowData = undefined;
            }

            if (!$(event.target).closest('#tb_hadiah tbody tr').length && $('#tb_hadiah tbody tr').hasClass('select-r2')) {
                $('#tb_hadiah tbody tr').removeClass('select-r2');
                selectedRowData2 = undefined;
            }

        });

        $('#button_insert').click(function(){
            if(selectedRowData === undefined){
                Swal.fire({
                    title: 'Peringatan..!',
                    text: `Harap pilih Data Master Terlebih Dahulu !`,
                    icon: 'warning',
                });
                return;
            }
            Swal.fire({
                title: 'Yakin?',
                text: `Apakah anda yakin ingin insert data ${selectedRowData.prdcd} ke PLU HADIAH PERISHABLE ?`,
                icon: 'warning',
                showCancelButton: true,
            })
            .then((result) => {
                if (result.value) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url:  `/plu-hadiah/action/insert`,
                        type: "POST",
                        data: { prdcd: selectedRowData.prdcd, desk: selectedRowData.desk },
                        success: function(response){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Success!',response.message,'success');
                            tb.ajax.reload();
                            tb_hadiah.ajax.reload();
                        },error: function (jqXHR, textStatus, errorThrown){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            if(jqXHR.responseJSON.code == 500){
                                var Errortext = ``;
                                jqXHR.responseJSON.errors.forEach((element, i, array) => {
                                    Errortext += `${element.message}`;
                                    i === array.length - 1 ? Errortext += ' Harus Diisi': Errortext += ' dan ';
                                });
                                Swal.fire('Peringatan..!',Errortext,'warning');
                            }else if(jqXHR.responseJSON.code == 400) {
                                Swal.fire('Oops!',jqXHR.responseJSON.message,'error');
                            }else {
                                Swal.fire('Oops!','Something wrong try again later (' + errorThrown + ')','error');
                            }
                        }
                    });
                }
            });
        });

        function actionDelete(){
            if(selectedRowData2 === undefined){
                Swal.fire({
                    title: 'Peringatan..!',
                    text: `Harap pilih Data PERISHABLE Terlebih Dahulu !`,
                    icon: 'warning',
                });
                return;
            }
            Swal.fire({
                title: 'Yakin?',
                text: `Apakah anda yakin ingin menghapus PLU ${selectedRowData2.prdcd} ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus PLU!'
            })
            .then((result) => {
                if (result.value) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url:  `/plu-hadiah/action/hapus/${selectedRowData2.prdcd}`,
                        type: "DELETE",
                        success: function(response){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Success!',response.message,'success');
                            tb.ajax.reload();
                            tb_hadiah.ajax.reload();
                        },error: function (jqXHR, textStatus, errorThrown){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            if(jqXHR.responseJSON.code === 400){
                                Swal.fire('Oops!',jqXHR.responseJSON.message,'error');
                            } else {
                                Swal.fire('Oops!','Something wrong try again later (' + errorThrown + ')','error');
                            }
                        }
                    });
                }
            });
        }

        $(document).keydown(function(e){
            if (e.keyCode === 46 && selectedRowData2 !== undefined) {
               e.preventDefault();
               actionDelete();
            }
        })
    </script>
    @endpush
@endsection


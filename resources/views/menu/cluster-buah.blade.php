@extends('master')
@section('title')
    <h1 class="pagetitle">CLUSTER BUAH</h1>
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

    #tb tbody tr {
        cursor: pointer;
    }
    
    .header-form .form-group > * {
        width: 200px;
        height: 35px;
    }

</style>
@endsection

@section('content')
    <script src="{{ url('js/home.js?time=') . rand() }}"></script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form id="form_simpan_action">
                                    <div class="d-flex align-items-center w-100 mb-2" style="gap: 15px">
                                        <div style="height: 35px; display: inline-block">
                                            <label class="header-label">KODE MOBIL</label>
                                        </div>
                                        <div class="header-form w-100">
                                            <div class="form-group w-100">
                                                <input type="text" class="form-control" name="kode_cluster" id="kode_cluster">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center w-100 mb-2" style="gap: 15px">
                                        <div style="height: 35px; display: inline-block">
                                            <label class="header-label">KODE TOKO</label>
                                        </div>
                                        <div class="header-form">
                                            <div class="form-group">
                                                <select name="kode_toko" id="list_toko" style="width: 250px" data-placeholder="PILIH TOKO" class="select2 form-control">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center w-100 mb-2" style="gap: 15px">
                                        <div style="height: 35px; display: inline-block">
                                            <label class="header-label">NAMA TOKO</label>
                                        </div>
                                        <div class="header-form w-100">
                                            <div class="form-group w-100">
                                                <input type="text" class="form-control" id="nama_toko" readonly style="width: 40%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center w-100 mb-2" style="gap: 15px">
                                        <div style="height: 35px; display: inline-block">
                                            <label class="header-label">No. Urut</label>
                                        </div>
                                        <div class="header-form w-100">
                                            <div class="form-group w-100">
                                                <input type="text" class="form-control" onkeypress="return hanyaAngka(event,false);" style="width: 80px" name="jarak_kirim" id="jarak_kirim">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center w-100 mb-2" style="gap: 15px">
                                        <div style="height: 35px; display: inline-block">
                                            <label class="header-label" style="background: white"></label>
                                        </div>
                                        <div class="header-form w-100" style="height: unset">
                                            <button class="btn btn-primary" style="width: 110px" type="submit">SIMPAN</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12" style="margin: 20px 0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover datatable-dark-primary w-100" id="tb">
                                        <thead>
                                            <tr>
                                                <th>Kode Mobil</th>
                                                <th>Kode Toko</th>
                                                <th>No. Urut</th>
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
        let selectedRowData;
        $(document).ready(function() {
            tb = $('#tb').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/cluster-buah/datatables',
                    type: 'GET'
                },
                columnDefs: [
                    { className: 'text-center', targets: [0,1,2] },
                ],
                order: [],
                columns: [
                    // { data: 'DT_RowIndex',searchable: false,orderable: false },
                    { data: 'clb_kode' },
                    { data: 'clb_toko' },
                    { data: 'clb_nourut' },
                ],
                rowCallback: function(row, data){
                    $(row).on('click', function() {
                        $('#tb tbody tr').removeClass('select-r');
                        $(this).toggleClass("select-r");
                        selectedRowData = data;
                    });
                }
            });
            loadToko();
        });

        $(document).on('click', function(event) {
            // Check if the clicked element is not a descendant of the table
            if (!$(event.target).closest('#tb tbody tr').length && !$(event.target).closest('#form_simpan_action').length && $('#tb tbody tr').hasClass('select-r')) {
                // Reset selectedRowData and remove 'select-r' class
                $('#tb tbody tr').removeClass('select-r');
                selectedRowData = undefined;
                $('.form-group-day input').prop('checked', false);
            }
        });

        function loadToko(){
            $("#modal_loading").modal('show');
            $.ajax({
                url:  `/cluster-buah/load-toko`,
                type: "get",
                success: function(response){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    response.data.forEach(element => {
                        $('#list_toko').append(`<option value="${element.tko_kodeomi}" data-namaomi="${element.tko_namaomi}">${element.tko_kodeomi}</option>`)
                    });
                },error: function (jqXHR, textStatus, errorThrown){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    Swal.fire('Oops!','Something wrong try again later (' + errorThrown + ')','error');
                }
            })
        }

        $('#form_simpan_action').submit(function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Yakin?',
                text: 'Apakah anda yakin ingin simpan jadwal kirim buah toko ?',
                icon: 'warning',
                showCancelButton: true,
            })
            .then((result) => {
                if (result.value) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url:  `/cluster-buah/action/save`,
                        type: "POST",
                        data: $('#form_simpan_action').serialize(),
                        success: function(response){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Success!',response.message,'success');
                            $('#form_simpan_action')[0].reset();
                            $('#list_toko').val(null).trigger('change');
                            tb.ajax.reload();
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
            Swal.fire({
                title: 'Yakin?',
                text: `Apakah anda yakin ingin menghapus toko ${selectedRowData.clb_toko} ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Toko!'
            })
            .then((result) => {
                if (result.value) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url:  `/cluster-buah/action/hapus/${selectedRowData.clb_toko}`,
                        type: "DELETE",
                        success: function(response){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Success!',response.message,'success');
                            $('#form_simpan_action')[0].reset();
                            $('#list_toko').val(null).trigger('change');
                            tb.ajax.reload();
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

        $('#list_toko').change(function(){
            var selectedOption = $(this).find(':selected');
            $('#nama_toko').val(selectedOption.data('namaomi'))
        });

        $(document).keydown(function(e){
            if (e.keyCode === 46 && selectedRowData !== undefined) {
               e.preventDefault();
               actionDelete();
            }
        })
    </script>
    @endpush
@endsection


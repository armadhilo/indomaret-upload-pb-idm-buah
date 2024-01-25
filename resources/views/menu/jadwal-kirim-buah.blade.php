@extends('master')
@section('title')
    <h1 class="pagetitle">JADWAL KIRIM BUAH</h1>
@endsection

@section('css')
<style>
    .header-form{
        height: 35px;
        display: inline-flex;
        gap: 14px;
    }

    .form-group-day{
        background: #6E214A;
        display: flex;
        align-items: center;
        padding: 12px;
        width: 120px;
        justify-content: center;
        gap: 6px;
    }

    .form-group-day input{
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .form-group-day label{
        color: white;
        margin: 0;
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
        width: 150px;
        height: 35px;
    }

    @media(max-width: 1350px){
        .form-group-day{
            width: 90px;
        }
    }

    @media(max-width: 1142px){
        .form-group-day{
            width: 72px;
        }

        .form-group-day label{
            font-size: .75rem;
        }
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
                        <div class="row">
                            <div class="col-12">
                                <form id="form_simpan_action">
                                    <div class="d-flex align-items-center w-100 mb-2" style="gap: 15px">
                                        <div style="height: 35px; display: inline-block">
                                            <label class="header-label">HARI</label>
                                        </div>
                                        <div class="header-form">
                                            <div class="form-group-day">
                                                <input type="checkbox" name="minggu">
                                                <label>MINGGU</label>
                                            </div>
                                            <div class="form-group-day">
                                                <input type="checkbox" name="senin">
                                                <label>SENIN</label>
                                            </div>
                                            <div class="form-group-day">
                                                <input type="checkbox" name="selasa">
                                                <label>SELASA</label>
                                            </div>
                                            <div class="form-group-day">
                                                <input type="checkbox" name="rabu">
                                                <label>RABU</label>
                                            </div>
                                            <div class="form-group-day">
                                                <input type="checkbox" name="kamis">
                                                <label>KAMIS</label>
                                            </div>
                                            <div class="form-group-day">
                                                <input type="checkbox" name="jumat">
                                                <label>JUM'AT</label>
                                            </div>
                                            <div class="form-group-day">
                                                <input type="checkbox" name="sabtu">
                                                <label>SABTU</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center w-100 mb-2" style="gap: 15px">
                                        <div style="height: 35px; display: inline-block">
                                            <label class="header-label">KODE TOKO</label>
                                        </div>
                                        <div class="header-form">
                                            <div class="form-group">
                                                <select name="kode_toko" id="list_toko" style="width: 200px" data-placeholder="PILIH TOKO" class="select2 form-control">
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
                                                <input type="text" class="form-control" name="nama_toko" id="nama_toko" readonly style="width: 40%">
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
                                                <th>TOKO</th>
                                                <th>MINGGU</th>
                                                <th>SENIN</th>
                                                <th>SELASA</th>
                                                <th>RABU</th>
                                                <th>KAMIS</th>
                                                <th>JUM'AT</th>
                                                <th>SABTU</th>
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
                    url: '/jadwal-kirim/datatables',
                    type: 'GET'
                },
                columnDefs: [
                    { className: 'text-center', targets: [0,1,2,3,4,5,6,7] },
                ],
                order: [],
                columns: [
                    // { data: 'DT_RowIndex',searchable: false,orderable: false },
                    { data: 'toko' },
                    { data: 'minggu' },
                    { data: 'senin' },
                    { data: 'selasa' },
                    { data: 'rabu' },
                    { data: 'kamis' },
                    { data: 'jumat' },
                    { data: 'sabtu' },
                ],
                rowCallback: function(row, data){
                    $(row).on('click', function() {
                        $('#tb tbody tr').removeClass('select-r');
                        $(this).toggleClass("select-r");
                        selectedRowData = data;
                        syncCheckBox(data.toko);
                        $("#list_toko").val(data.toko).change();
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

        function syncCheckBox(toko){
            $("#modal_loading").modal('show');
            $.ajax({
                url:  `/jadwal-kirim/load-detail-hari/${toko}`,
                type: "get",
                success: function(response){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    $('.form-group-day input').prop('checked', false);
                    // $('#list_toko').val(null).trigger('change');
                    response.data.forEach(element => {
                        $(`[name=${element.jkb_hari.toLowerCase()}]`).prop('checked', true);
                    });
                },error: function (jqXHR, textStatus, errorThrown){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    Swal.fire('Oops!','Something wrong try again later (' + errorThrown + ')','error');
                }
            })
        }


        function loadToko(){
            $("#modal_loading").modal('show');
            $.ajax({
                url:  `/jadwal-kirim/load-toko`,
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
            if($('#list_toko').val() == null || $('#list_toko').val() == ''){
                Swal.fire({
                    title: 'Peringatan..!',
                    text: `Harap pilih Kode Toko Terlebih Dahulu !`,
                    icon: 'warning',
                })
                return;
            }
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
                        url:  `/jadwal-kirim/action/save`,
                        type: "POST",
                        data: $('#form_simpan_action').serialize(),
                        success: function(response){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Success!',response.message,'success');
                            $('#list_toko').val(null).trigger('change');
                            $('.form-group-day input').prop('checked', false);
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
        });

        function actionDelete(){
            Swal.fire({
                title: 'Yakin?',
                text: `Apakah anda yakin ingin menghapus toko ${selectedRowData.toko} ?`,
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
                        url:  `/jadwal-kirim/action/hapus/${selectedRowData.toko}`,
                        type: "DELETE",
                        success: function(response){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Success!',response.message,'success');
                            $('#list_toko').val(null).trigger('change');
                            $('.form-group-day input').prop('checked', false);
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


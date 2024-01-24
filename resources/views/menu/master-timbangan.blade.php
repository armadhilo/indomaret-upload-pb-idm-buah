@extends('master')
@section('title')
    <h1 class="pagetitle">MASTER TIMBANGAN</h1>
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
        box-shadow: 0 2px 6px #e1ad65;
        background: #ef9b26;
        color: white;
        border: unset!important;
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

    .selected-row td {
        background-color: #0076ffa1 !important;
        color: white;
    }

    .detail-input{
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .detail-input label{
        white-space: nowrap;
        display: block;
        width: 110px;
        background: rgb(53,70,179);
        color: white;
        padding: 3px;
        text-align: center;
        margin: 0;
    }

    #btn_jadwal_kirim{
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    #btn_jadwal_kirim .btn{
        flex: 1;
        font-size: .9rem;
        white-space: nowrap;
    }

    #tb tbody tr {
        cursor: pointer;
    }

    .detail-info{
        top: -14px;
        font-size: 1.1rem;
        background: white;
        font-weight: 600;
        padding: 0 5px;
        color: #012970;
    }

    @media(max-width: 1400px){
        #display_help{
            display: none;
        }
    }

    @media(max-width: 1545px){
        #tb{
            zoom: 90%;
        }
    }


    @media(max-width: 1582px){
        #display_help{
            padding: 4px 9px;
            font-size: .8rem;
        }

        #plu_igr, #plu_idm{
            width: 40%!important;
        }

        #deskripsi{
            width: 72%!important;
        }

        label{
            font-size: 13px!important;
        }

        .table td{
            font-size: .9rem
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
                            <div class="col-12 col-xl-6" style="margin: 20px 0">
                                <table class="table table-striped table-hover datatable-dark-primary w-100" id="tb">
                                    <thead>
                                        <tr>
                                            <th>PLU IGR</th>
                                            <th>PLU BUAH</th>
                                            <th>Deskripsi</th>
                                            <th>Avg. Cost</th>
                                            <th>Exp. Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 col-xl-6">
                                <div class="detail">
                                    <div class="row position-relative" style="padding: 20px 20px; border: 1px solid lightgray; margin: 20px 20px">
                                        <p style="position: absolute" class="detail-info">Action</p>
                                        <form id="form_add" class="w-100">
                                            <div class="col-12">
                                                <div class="form-group detail-input">
                                                    <label for="">PLU IGR</label>
                                                    <input type="text" class="form-control" name="pluigr" style="width: 50%" id="plu_igr">
                                                    <span id="display_help" style="padding: 4px 10px; background: #E74A3B; color: white; font-weight: 700; border-radius: 3px">* F1 - HELP</span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group detail-input">
                                                    <label for="">DESKRIPSI</label>
                                                    <input type="text" class="form-control" readonly style="width: 80%" id="deskripsi">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group detail-input">
                                                    <label for="">PLU BUAH</label>
                                                    <input type="text" class="form-control" name="plubuah" onkeypress="return hanyaAngka(event,false);" style="width: 50%" id="plu_buah">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-success float-right mt-2" style="width: 20%;">ADD</button>
                                            </div>
                                        </form>
                                        <div class="w-100 mt-4 pt-4" style="padding: 0 12px; border-top: 6px solid #f3f4f5;">
                                            <div class="form-group" id="btn_jadwal_kirim">
                                                <button class="btn btn-warning" onclick="actionUpdateAllData();">UPDATE ALL DATA</button>
                                                <button class="btn btn-warning" onclick="actionKirimTimbangan();">KIRIM KE TIMBANGAN</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
           <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Help Timbangan Buah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-primary mb-3" onclick="tb_igr.ajax.reload();">Refresh</button>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover datatable-dark-primary w-100" id="tb_igr" style="margin: 20px">
                            <thead>
                                <tr>
                                    <th>PLU IGR</th>
                                    <th>Deskripsi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
           </div>
        </div>
    </div>

    @push('page-script')
    <script>
        let tb;
        let tb_igr;
        let selectedRowData;
        $(document).ready(function() {
            tb = $('#tb').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/master-timbangan/datatables',
                    type: 'GET'
                },
                columnDefs: [
                    { className: 'text-center', targets: [0,1,3,4] },
                ],
                order: [],
                columns: [
                    // { data: 'DT_RowIndex',searchable: false,orderable: false },
                    { data: 'pluigr' },
                    { data: 'plu_bh' },
                    { data: 'desk' },
                    { data: 'acost' },
                    { data: 'exp_date' },
                ],
                rowCallback: function(row, data){
                    $(row).on('click', function() {
                        $('#tb tbody tr').removeClass('select-r');
                        $(this).toggleClass("select-r");
                        selectedRowData = data;
                    });
                }
            });

            tb_igr = $('#tb_igr').DataTable({
                processing: true,
                ajax: {
                    url: '/master-timbangan/datatables-help-timbangan',
                    type: 'GET'
                },
                columnDefs: [
                    { className: 'text-center', targets: [0,2] },
                ],
                columns: [
                    { data: 'prc_pluigr' },
                    { data: 'desc' },
                    { data: null },
                ],
                rowCallback: function (row, data) {
                    $('td:eq(2)', row).html(`<button class="btn btn-info btn-sm mr-1" onclick="pilihIgr('${data.prc_pluigr}', '${data.desc}')">Pilih IGR</button>`);
                }
            });
        });

        function pilihIgr(pluigr, desk){
            $('#modal').modal("hide");
            $('#plu_igr').val(pluigr);
            $('#deskripsi').val(desk);
            $('#plu_buah').focus();
        }

        function actionDelete(){
            Swal.fire({
                title: `Yakin..?`,
                text: `Apakah anda yakin ingin menghapus data ${selectedRowData.desk}..?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Data!'
            })
            .then((result) => {
                if (result.value) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url:  `/master-timbangan/action/hapus/${selectedRowData.pluigr}/${selectedRowData.desk}`,
                        type: "delete",
                        success: function(response){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Success!',response.message,'success');
                            selectedRowData = undefined;
                            tb.ajax.reload();
                        },error: function (jqXHR, textStatus, errorThrown){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Oops!','Something wrong try again later (' + errorThrown + ')','error');
                        }
                    })
                }
            })
        }

        function actionUpdateAllData(){
            Swal.fire({
                title: `Yakin..?`,
                text: `Apakah anda yakin ingin melakukan update all data...?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            })
            .then((result) => {
                if (result.value) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url:  `/master-timbangan/action/update-all-data`,
                        type: "get",
                        success: function(response){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Success!',response.message,'success');
                            tb.ajax.reload();
                            $('#deskripsi').val('');
                            $('#plu_buah').val('');
                            $('#plu_igr').val('');
                            $('#plu_igr').focus();
                        },error: function (jqXHR, textStatus, errorThrown){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Oops!','Something wrong try again later (' + errorThrown + ')','error');
                        }
                    })
                }
            })
        }

        function actionKirimTimbangan(){
            Swal.fire({
                title: `Yakin..?`,
                text: `Apakah anda yakin ingin melakukan action kirim timbangan...?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            })
            .then((result) => {
                if (result.value) {
                    window.location.href = '/master-timbangan/action/kirim';
                }
            })
        }


        $("#plu_igr").on("focus", function() {
            // Event listener for key press
            $(document).on("keypress.plu_igr", function(event) {
            // Check if the pressed key is Enter (key code 13)
            if (event.which === 13) {
                event.preventDefault();
                $("#modal_loading").modal('show');
                $.ajax({
                    url:  "/master-timbangan/detail/" + $('#plu_igr').val(),
                    type: "GET",
                    success: function(response){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        if(response.data !== null){
                            Swal.fire('Success!',response.message,'success');
                            $('#deskripsi').val(response.data.desc);
                            $('#plu_buah').focus();
                        } else {
                            Swal.fire('Oops!','Detail PLUIGR Tidak Ditemukan','error');
                        }
                    },error: function (jqXHR, textStatus, errorThrown){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        Swal.fire('Oops!','Something wrong try again later (' + errorThrown + ')','error');
                    }
                })
            }
            });
        });


        $('#plu_igr').on("keyup", function(){
            if($('#deskripsi').val() !== ''){
                $('#deskripsi').val('');
            }
        })

        $(document).on('click', function(event) {
            // Check if the clicked element is not a descendant of the table
            if (!$(event.target).closest('#tb tbody tr').length) {
                // Reset selectedRowData and remove 'select-r' class
                $('#tb tbody tr').removeClass('select-r');
                selectedRowData = undefined;
            }
        });

        $("#plu_igr").on("blur", function() {
            // Remove the keypress event listener when input loses focus
            $(document).off("keypress.plu_igr");
        });

        $('#form_add').submit(function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Yakin?',
                text: 'Apakah anda yakin ingin melakukan action ini ?',
                icon: 'warning',
                showCancelButton: true,
            })
            .then((result) => {
                if (result.value) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url:  "/master-timbangan/action/add",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(response){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            if(response.code === 200){
                                Swal.fire({
                                    title: "Success",
                                    text: response.message,
                                    icon: "success"
                                }).then(function(){
                                    tb.ajax.reload();
                                    $('#plu_igr').val('');
                                    $('#deskripsi').val('');
                                    $('#plu_buah').val('');
                                });
                            }
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
                    })
                }
            })
        });

        $(document).keydown(function(e){
            if(e.which === 112) {
                e.preventDefault();
                $("#modal").modal("show");
            }

            if (e.keyCode === 46 && selectedRowData !== undefined) {
               e.preventDefault();
               actionDelete();
            }
        })
    </script>
    @endpush
@endsection


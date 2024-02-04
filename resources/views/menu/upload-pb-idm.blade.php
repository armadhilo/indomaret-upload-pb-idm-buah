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

    #header_tb_modal{
        background: #6E214A;
        padding: 6px;
        color: white;
        margin-bottom: 15px;
        display: inline-block;
        border: 2px groove lightgray;
    }

    #header_tb_modal h5{
        margin: 0;
        font-size: 1rem;
        font-weight: bold;
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
                                <table class="table table-striped table-hover w-100 datatable-dark-primary table-center" id="tb_header" style="margin-top: 20px">
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
                                <table class="table table-striped table-hover table-center w-100 datatable-dark-primary" id="tb_detail" style="margin-top: 20px">
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

    <div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" style="max-width: 75%;" role="document">
           <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Urutan PLU Buah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="header_tb_modal">
                        <h5>* DOUBLE CLICK UNTUK SELECT DATA & TEKAN PAGE UP/DOWN UNTUK MENGUBAH URUTAN</h5>
                    </div>
                    <input type="hidden" id="jenis_pb_urutan_buah">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover datatable-dark-primary w-100" id="tb_urutan_buah" style="margin: 20px">
                            <thead>
                                <tr>
                                    <th>PLU</th>
                                    <th>Deskripsi</th>
                                    <th>Unit</th>
                                    <th>Fraction</th>
                                    <th>TotalQTY</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-success" onclick="prosesFormNoUrut()" id="proses_no_urut_button">Proses PB Buah</button>
                    <button type="button" class="btn btn-warning d-none" onclick="prosesFormBuah()" id="pb_buah_button">Proses PB Buah</button>
                </div>
           </div>
        </div>
    </div>

    @push('page-script')

    <script>
        let tb_header;
        let tb_detail;
        let selectedRowData;

        let tb_urutan_buah;
        let updated_data;

        function initializeDatatables(){
            tb_header = $('#tb_header').DataTable({
                processing: true,
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
                data: [],
                rowCallback: function(row, data){
                    $(row).dblclick(function() {
                        $('#tb_header tbody tr').removeClass('select-r');
                        $(this).addClass("select-r");
                        selectedRowData = data;
                        showDatatableDetail(data.nopb, data.tglpb, data.toko);
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
                    { data: 'rupiah'},
                    { data: 'stock'},
                ],
                columnDefs: [
                    { className: 'text-center-vh', targets: '_all' },
                ],
                data: [],
                rowCallback: function(row, data){
                },
            });

            tb_urutan_buah = $('#tb_urutan_buah').DataTable({
                language: {
                    emptyTable: "<div class='datatable-no-data' style='color: #ababab'>Tidak Ada Data</div>",
                },
                columns: [
                    { data: 'plu'},
                    { data: 'desk'},
                    { data: 'unit'},
                    { data: 'frac'},
                    { data: 'totalqty'},
                    { data: 'stock'},
                ],
                data: [],
                columnDefs: [
                    { className: 'text-center-vh', targets: '_all' },
                ],
                rowCallback: function(row, data){
                    $(row).dblclick(function() {
                        $('#tb_urutan_buah tbody tr').removeClass('select-r');
                        $(this).addClass("select-r");
                    });
                },
                paging: false,
                searching: false,
                info: false,
                order: [],
            });
        }
        $(document).ready(function(){
            initializeDatatables();
            showDatatablesHead();
        });

        function showDatatablesHead(){
            tb_header.clear().draw();
            tb_detail.clear().draw();
            $('.datatable-no-data').css('color', '#F2F2F2');
            $('#loading_datatable').removeClass('d-none');
            $('#loading_datatable_detail').removeClass('d-none');
            $.ajax({
                url: "/upload-pb-idm/datatablesHeader",
                type: "GET",
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#loading_datatable').addClass('d-none');
                    $('.datatable-no-data').css('color', '#ababab');
                    tb_header.rows.add(response.data).draw();
                    $('#tb_header tbody tr:first').dblclick();
                }, error: function(jqXHR, textStatus, errorThrown) {
                    setTimeout(function () { $('#loading_datatable').addClass('d-none'); }, 500);
                    $('#loading_datatable_detail').addClass('d-none');
                    $('.datatable-no-data').css('color', '#ababab');
                    Swal.fire({
                        text: "Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")",
                        icon: "error"
                    });
                }
            });
        }

        function showDatatableDetail(noPb, tglPb, toko){
            tb_detail.clear().draw();
            $('.datatable-no-data').css('color', '#F2F2F2');
            $('#loading_datatable_detail').removeClass('d-none');
            $.ajax({
                url: `/upload-pb-idm/datatablesDetail/${noPb}/${tglPb}/${toko}`,
                type: "GET",
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#loading_datatable_detail').addClass('d-none');
                    $('.datatable-no-data').css('color', '#ababab');
                    tb_detail.rows.add(response.data).draw();
                }, error: function(jqXHR, textStatus, errorThrown) {
                    setTimeout(function () { $('#loading_datatable_detail').addClass('d-none'); }, 500);
                    $('.datatable-no-data').css('color', '#ababab');
                    Swal.fire({
                        text: "Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")",
                        icon: "error"
                    });
                }
            });
        }

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

        function tarikAlokasiBuah(){
            if(tb_header.rows().data().length < 1){
                Swal.fire({
                    title: 'Peringatan..!',
                    text: `Belum Ada PB Reguler !!`,
                    icon: 'warning',
                });
                return;
            }
            Swal.fire({
                title: 'Yakin?',
                text: `Yakin Akan Proses Alokasi (Sudah Tarik Semua Data PBBH) ??`,
                icon: 'warning',
                showCancelButton: true,
            })
            .then((result) => {
                if (result.value) {
                    $('#modal_loading').modal('show');
                    $.ajax({
                        url: `/upload-pb-idm/action/proses-alokasi`,
                        type: "GET",
                        success: function(response) {
                            setTimeout(function () { $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Success!',response.message,'success').then(function(){
                                showDatatablesHead();
                            });
                        }, error: function(jqXHR, textStatus, errorThrown) {
                            setTimeout(function () { $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire({
                                text: (jqXHR.responseJSON && jqXHR.responseJSON.code === 400)
                                    ? jqXHR.responseJSON.message
                                    : "Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")",
                                icon: "error"
                            });
                        }
                    });
                }
            })
        }

        $(document).keydown(function(e) {
            const keyCode = e.which || e.keyCode;

            if (keyCode === 114) {
                e.preventDefault();
                uploadCSV();
            } else if (keyCode === 119 || keyCode === 120 || keyCode === 121) {
                e.preventDefault();
                const jenisPB = getJenisPB(keyCode);
                Swal.fire({
                    title: 'Yakin?',
                    text: `Apakah anda yakin ingin memproses ${jenisPB} ?`,
                    icon: 'warning',
                    showCancelButton: true,
                })
                .then((result) => {
                    if (result.value) {
                        queryUrutanBuah(jenisPB);
                    }
                });
            } else if (e.which === 117 || e.keyCode === 117){
                tarikAlokasiBuah();
            }
        });

        // Urutan PLU Buah Function 

        function getJenisPB(keyCode) {
            if (keyCode === 119) {
                return 'IMPORT';
            } else if (keyCode === 120) {
                return 'LOKAL';
            } else if (keyCode === 121) {
                return 'CHILLED FOOD';
            }
        }

        function queryUrutanBuah(jenisPB){
            if(tb_header.rows().data().length < 1){
                Swal.fire({
                    title: 'Peringatan..!',
                    text: `Tidak Ada Data ${jenisPB} Yang Dapat Diproses !`,
                    icon: 'warning',
                });
                return;
            }
            $('#modal_loading').modal('show');
            tb_urutan_buah.clear().draw();
            $.ajax({
                url: `/upload-pb-idm/datatablesUrutanBuah/${jenisPB}`,
                type: "GET",
                contentType: false,
                processData: false,
                success: function(response) {
                    setTimeout(function () { $('#modal_loading').modal('hide'); }, 500);
                    tb_urutan_buah.rows.add(response.data).draw();
                    $('#jenis_pb_urutan_buah').val(jenisPB);
                    $('#pb_buah_button').addClass('d-none');
                    $('#proses_no_urut_button').attr('disabled', false);
                    $('#modal').modal('show');
                }, error: function(jqXHR, textStatus, errorThrown) {
                    setTimeout(function () { $('#modal_loading').modal('hide'); }, 500);
                    Swal.fire({
                        text: "Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")",
                        icon: "error"
                    });
                }
            });

        }

        $('#modal').on('hidden.bs.modal', function () {
            tb_urutan_buah.clear().draw();
            updatedData = undefined;
            $('#pb_buah_button').addClass('d-none');
            $('#proses_no_urut_button').attr('disabled', false);
            $('#jenis_pb_urutan_buah').val(null)
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('#tb_urutan_buah tbody tr').length && $('#tb_urutan_buah tbody tr').hasClass('select-r')) {
                $('#tb_urutan_buah tbody tr').removeClass('select-r');
            }
        });

        function getUpdatedData() {
            updatedData = [];
            $('tbody tr', tb_urutan_buah.table().node()).each(function () {
                var rowData = {};
                $('td', this).each(function (i) {
                    rowData[$('th', tb_urutan_buah.table().node()).eq(i).text()] = $(this).text();
                });
                updatedData.push(rowData);
            });
            return updatedData;
        }

        $(document).on('keydown', function(e) {
            var selectedRow = $('#tb_urutan_buah tbody tr.select-r');

            if (selectedRow.length === 1) {
                e.preventDefault();
                
                if (e.key === 'PageUp') {
                    selectedRow.insertBefore(selectedRow.prev());
                } else if (e.key === 'PageDown') {
                    selectedRow.insertAfter(selectedRow.next());
                }
            }
        });

        function prosesFormBuah(){
            if(tb_header.rows().data().length < 1){
                Swal.fire({
                    title: 'Peringatan..!',
                    text: `Tidak Ada Data ${jenisPB} Yang Dapat Diproses !`,
                    icon: 'warning',
                });
                return;
            }
            Swal.fire({
                title: 'Yakin?',
                text: `Apakah anda yakin ingin melakukan proses Form Buah ?`,
                icon: 'warning',
                showCancelButton: true,
            })
            .then((result) => {
                if (result.value) {
                    $('#modal_loading').modal('show');
                    $.ajax({
                        url: `/upload-pb-idm/action/proses-pb-buah`,
                        type: "POST",
                        data: {jenisPB: $('#jenis_pb_urutan_buah').val()},
                        success: function(response) {
                            setTimeout(function () { $('#modal_loading').modal('hide'); }, 500);
                            $('#modal').modal('hide');
                            Swal.fire('Success!',response.message,'success').then(function(){
                                showDatatablesHead();
                                window.open('/upload-pb-idm/download-zip/' + response.data, '_blank');
                            });
                        }, error: function(jqXHR, textStatus, errorThrown) {
                            setTimeout(function () { $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire({
                                text: "Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")",
                                icon: "error"
                            });
                        }
                    });
                }
            })
        }

        function prosesFormNoUrut(){
            if(tb_header.rows().data().length < 1){
                Swal.fire({
                    title: 'Peringatan..!',
                    text: `Tidak Ada Data ${jenisPB} Yang Dapat Diproses !`,
                    icon: 'warning',
                });
                return;
            }
            var jenisPB = $('#jenis_pb_urutan_buah').val();
            Swal.fire({
                title: 'Yakin?',
                text: `Sudah Yakin dengan urutan PLU Picking ${jenisPB} ?`,
                icon: 'warning',
                showCancelButton: true,
            })
            .then((result) => {
                if (result.value) {
                    var datatableData = getUpdatedData();
                    if(datatableData[0].PLU === "Tidak Ada Data" && datatableData.length == 1){
                        Swal.fire({
                            title: 'Peringatan..!',
                            text: `Tidak Ada Data ${jenisPB} Yang Dapat Diproses !`,
                            icon: 'warning',
                        });
                        return;
                    }
                    $('#modal_loading').modal('show');
                    $.ajax({
                        url: `/upload-pb-idm/action/proses-urutan-buah`,
                        type: "POST",
                        data: {jenisPB: jenisPB, datatables: datatableData},
                        success: function(response) {
                            setTimeout(function () { $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire('Success!',response.message,'success');
                            $('#pb_buah_button').removeClass('d-none');
                            $('#proses_no_urut_button').attr('disabled', true);
                        }, error: function(jqXHR, textStatus, errorThrown) {
                            setTimeout(function () { $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire({
                                text: (jqXHR.responseJSON && jqXHR.responseJSON.code === 400)
                                    ? jqXHR.responseJSON.message
                                    : "Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")",
                                icon: "error"
                            });
                        }
                    });
                }
            })
        }
    </script>
    @endpush
@endsection


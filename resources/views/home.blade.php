@extends('master')
@section('title')
    <h4>UPDATE HARGA JUAL</h4>
@endsection

@section('content')
    <script src="{{ url('js/home.js?time=') . rand() }}"></script>

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="form-group row mt-4 mx-0" style="gap: 30px">
                    <button class="col btn btn-primary" onclick="buttonClick('action/pos','Apakah anda yakin ingin mengupdate harga jual ke seluruh kasir?')">SEND TO POS</button>
                    <button class="col btn btn-info" onclick="buttonClick('action/spi','Apakah anda yakin ingin mengupdate harga jual ke SPI?')">SEND TO SPI</button>
                    <button class="col btn btn-danger" onclick="buttonClick('action/klik','Apakah anda yakin ingin mengupdate harga jual ke KlikIGR?')">SEND TO KLIK</button>
                </div>
                <br>
            </div>
        </div>
    </div>

    @push('page-script')
    <script>
        function buttonClick(url, text){
            Swal.fire({
                title: "Yakin?",
                text: text,
                showCancelButton: true,
                showConfirmButton: true,
                icon: "info",
                confirmButtonText: "Save",
            })
            .then((result) => {
                if(result.value){
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/home/' + url,
                        type: 'GET',
                        success: function( response, textStatus, jQxhr ){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            if (jQxhr.status === 200) {
                                let blobData = new Blob([response], {type: jQxhr.getResponseHeader('Content-Type') })

                                var a = document.createElement('a');
                                var url = window.URL.createObjectURL(blobData);

                                a.href = url;
                                a.download = jQxhr.getResponseHeader('filename') || 'file.txt';
                                document.body.appendChild(a);
                                a.click();

                                window.URL.revokeObjectURL(url);
                                document.body.removeChild(a);
                            }
                        },error: function (jqXHR, textStatus, errorThrown){
                            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                            Swal.fire("Error", jqXHR.responseJSON.message, 'error');
                            Object.keys(jqXHR.responseJSON.errors).forEach(function (key) {
                                var responseError = jqXHR.responseJSON.errors[key];
                                var elem_name = $('[name=' + responseError['field'] + ']');
                                var elem_feedback = $('[id=invalid-' + responseError['field'] + '-feedback'+']');
                                elem_name.addClass('is-invalid');
                                elem_feedback.text(responseError['message']);
                            });
                        }
                    });
                }
            })
        }
    </script>
    @endpush
@endsection

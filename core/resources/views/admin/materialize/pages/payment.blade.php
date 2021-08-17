@extends(admin_theme().'layout')
    @section('title', 'Danh sách tra cứu')

    @section('content')


    <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-light-blue">
                <h2>DANH SÁCH GÓI CƯỚC</h2>
                <ul class="header-dropdown m-r--5">
                    <li>
                        <a href="javascript:void(0);" id="tbl-reload" data-toggle="cardloading" data-loading-effect="timer">
                            <i class="material-icons">loop</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body">
                
                <div class="row clearfix">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-striped table-list-user">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên gói</th>
                                    <th>Lượt scan</th>
                                    <th>Ngày sử dụng</th>
                                    <th>Giá</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>Không giới hạn</td>
                                    <td>{{ $item->payment_type == 1 ? '365 Ngày' : '30 Ngày' }}</td>
                                    <td>{{ $item->price}}</td>
                                    <td>Full chức năng</td>
                                    <td><button type="button" data-id='{{ $item->id }}' class="btn btn-danger waves-effect btn_transaction">Thanh toán</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @endsection

    @push('css')

    <!-- JQuery DataTable Css -->
    <link href="{{ admin_asset('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ admin_asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ admin_asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />

    @endpush

    @push('js')
    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ admin_asset('plugins/jquery-countto/jquery.countTo.js') }}"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ admin_asset( 'plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ admin_asset( 'plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ admin_asset( 'plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ admin_asset( 'plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ admin_asset( 'plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ admin_asset( 'plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ admin_asset( 'plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ admin_asset( 'plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ admin_asset( 'plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ admin_asset( 'plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <!-- Moment Plugin Js -->
    <script src="{{ admin_asset( 'plugins/momentjs/moment.js') }}"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ admin_asset( 'plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>



    <script>
    //Widgets count
    $('.count-to').countTo();

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $('.btn_transaction').click( function () {
        var chk     = $(this);
        var id      = chk.data('id');
        $.post('/admincp/order', {
            'id': id,
        }, function(res) {
            console.log(res);
            swal({
                title: "Bạn đã chọn gói cước thành công !",
                text: " Bạn hãy chuyển khoản để hoàn tất quá trình thanh toán.",
                type: "success",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Tôi đồng ý!",
                closeOnConfirm: false,
            }, function (isConfirm) {
                if (isConfirm) {
                    window.location.href = "/admincp/transaction";
                } else {
                    window.location.href = "/admincp/transaction";
                }
            });
        });
    });

    


    </script>
    @endpush
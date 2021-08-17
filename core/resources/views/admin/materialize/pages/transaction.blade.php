@extends(admin_theme().'layout')
    @section('title', 'Danh sách tra cứu')

    @section('content')


    <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12">
        <div class="card">
            <div class="header bg-red">
                <h2>
                    Thông tin thanh toán bằng chuyển khoản
                </h2>
            </div>
            <div class="body">
            <p> Chủ Tài Khoản: Hoàng Bạch Thái Dương </p>
            <p>Số TK: 19032965706011</p>
            <p>NH Techcombank. CN Đinh Bộ Lĩnh Tp.HCM</p>
            <p>Nội dung chuyển khoản: "mã giao dịch" + SDT</p>
            <p> Ví dụ: FF-MUSG1ULF  0934163898 </p>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-light-blue">
                <h2>DANH SÁCH GIAO DỊCH</h2>
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
                                    <th>Mã giao dịch</th>
                                    <th>Tên gói</th>
                                    <th>Giá</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đăng ký</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as  $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->Payment->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->status == 1 ? 'Thành công' : 'Đang đợi' }}</td>
                                    <td>{{ $item->updated_at}}</td>
                                    <td><button type="button" data-id='{{ $item->id }}' class="btn btn-danger waves-effect btn_del_transaction">Xoá</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $data->links() }}
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

    $('.btn_del_transaction').click( function () {
        var chk     = $(this);
        var id      = chk.data('id');
        $.post('/admincp/delete-transaction', {
            'id': id,
        }, function(res) {
            window.location.reload();
        });
    });

    </script>
    @endpush
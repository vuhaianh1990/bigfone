    @extends(admin_theme().'layout')
    @section('title', 'Danh sách tra cứu')

    @section('content')


    <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-light-blue">
                <h2>DANH SÁCH USER</h2>
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
                                    <th>Avatar</th>
                                    <th>Tên</th>
                                    <th>Điện thoại</th>
                                    <th>Lượt tra cứu</th>
                                    <th>Ngày đăng ký</th>
                                    <th>Đã gọi</th>
                                    <th>Ghi chú </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <tr>
                                    <td><img style='width:30px' src="{{ $item->avatar }}" /></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->profit < 1 ? 'Chưa dùng' : $item->profit }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <div class="switch">
                                            <label><input type="checkbox" class='checkbox_call' data-id="{{ $item->id }}" data-value="{{ $item->call }}" {{ $item->call == '1' ? 'checked' : '' }}><span class="lever switch-col-light-blue"></span></label>
                                        </div>
                                    </td>
                                    <td>
                                    <textarea rows="2" class="form-control no-resize ghichu_user"  data-id="{{ $item->id }}">{{ $item->ghichu }}</textarea>
                                    </td>
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

    $('.table-list-user').on( 'click', '.checkbox_call', function () {
        var chk     = $(this);
        var id      = chk.data('id');
        var value   = chk.data('value');
        var name    =   'call';

        $.post('/admincp/switchCallUser', {
            'name': name,
            'value': value,
            'id': id,
        }, function(res) {
            
        });
    });

    $('.ghichu_user').change(function(){
    var chk     = $(this);
    var id      = chk.data('id');
    var value   = chk.val();
    var name    = 'ghichu';

    $.post('/admincp/switchCallUser', {
        'name': name,
        'value': value,
        'id': id,
    }, function(res) {
        
    });
    });

    //   $('#tbl-scan tbody').on( 'submit', '#frm-scan', function (e) {
    //     e.preventDefault();

    //     $.ajax({
    //       type: "POST",
    //       url: '/admincp/changeData',
    //       data: $(this).serialize(),
    //       success: function(res) {
    //         if (res.status === 200) {
    //           swal("Chúc mừng!", "Bạn đã chỉnh sửa thành công!", "success");
    //           setTimeout(function () {
    //             location.reload();
    //         }, 2000);
    //         } else {
    //           swal("Lỗi!", "Lỗi không thể thay đổi nội dung!", "error");
    //         }
    //       }
    //     });
    //   });

    </script>
    @endpush
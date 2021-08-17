@extends(admin_theme().'layout')
@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-light-blue">
                <h2>DANH SÁCH ĐƠN HÀNG</h2>
                <ul class="header-dropdown m-r--5">
                    <li>
                        <a href="javascript:void(0);" id="tbl-reload" data-toggle="cardloading" data-loading-effect="timer">
                            <i class="material-icons">loop</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row date-filter clearfix">
                    <div class="col-sm-2" style="margin: 10px 0 0">Tìm kiếm theo ngày:</div>
                    <div class="col-sm-2">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="date_start" class="datepicker form-control" placeholder="Ngày bắt đầu" data-dtp="dtp_SoZjf1">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="date_end" class="datepicker form-control" placeholder="Ngày kết thúc" data-dtp="dtp_SoZjf2">
                        </div>
                    </div>
                </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-12 table-responsive">
                        <table id="tbl-admin-transaction" class="table table-bordered table-striped table-hover dataTable"></table>
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


<!-- Custom Datatables -->
<script src="{{ admin_asset( 'js/superadmin-transaction-datatables.js') }}"></script>

<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $('#tbl-admin-transaction').on( 'click', '.btn_accept_transaction', function (e) {
        var id = $(this).data('id');
        $.post('/admincp/acceptTransaction', {
            'id': id,
        }, function(res) {
            if (res.status === 200) {
                swal({
                    title: "Nâng cấp tài khoản thành công !",
                    text: "Nâng cấp tài khoản lên VIP thành công!",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Tôi đồng ý!",
                    closeOnConfirm: false,
                }, function (isConfirm) {
                    if (isConfirm) {
                        window.location.href = "/admincp/list-transaction";
                    } else {
                        window.location.href = "/admincp/list-transaction";
                    }
                });
            } else if (res.status == 400 || res.status == 401) {
                swal("Lỗi!", "Hệ thống không thay đổi giá trị!", "error");
            }
            
        });
    });
</script>
@endpush
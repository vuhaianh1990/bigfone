@extends(admin_theme().'layout')
@section('title', 'Danh sách active')

@section('content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-light-blue">
                <h2>DANH SÁCH ACTIVE</h2>
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
                    <table id="tbl-active" class="table table-bordered table-striped table-hover dataTable"></table>
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
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var table = $('#tbl-active').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,

    lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
    language: {
        "lengthMenu": "Hiển thị _MENU_ dòng",
        "zeroRecords": "Không tìm thấy dữ liệu trong bảng",
        "info": "Hiển thị trang _PAGE_ trong _PAGES_ trang",
        "infoEmpty": "Không có dữ liệu",
        "infoFiltered": "(Tìm thấy _MAX_ kết quả)",
        "search": "Tìm kiếm:",
        "paginate": {
          "first":      "Đầu",
          "last":       "Cuối",
          "next":       "Sau",
          "previous":   "Trước"
        },
    },
    ajax: {
      'url': "/admincp/list-active"
    },
    columns: [
      {
        'title': 'Picture',
        'data': 'avatar',
        'render': function(data, type, row) {
          var avatar = row.avatar;
          if (avatar == '' || avatar === null || typeof avatar === 'undefined') {
            avatar = '/themes/materialize/images/user.svg';
          }
          return '<img src="'+ avatar +'" width="50" />';
        }
      },
      {
        'title': 'Tên',
        'data': 'name'
      },
      {
        'title': 'UID',
        'data': 'uid'
      },
      {
        'title': 'Phone',
        'data': 'phone',
        'render': function(data, type, row) {
          if (!row.phone) return '-';
          return row.phone
        }
      },
      {
        'title': 'Active',
        'data': 'usertype',
        'render': function(data, type, row) {
          var checked = '';
          if (row.usertype == 1) {
            checked = 'checked';
          }
          return '<div class="switch"><label><input type="checkbox" name="usertype" class="chk" id="'+ row.id +'" data-id="'+ row.id +'" data-value="'+ row.usertype +'" '+ checked +'><span class="lever switch-col-green"></span></label></div>';
        }
      },
      {
        'title': 'Ngày hết hạn',
        'data': 'expired',
        'render': function(data, type, row) {
          expired = row.expired;
          if (!expired) {
            expired = '';
          } else {
            expired = moment(expired).format('YYYY-MM-DD');
          }
          return '<input type="date" name="expired" value="'+ expired +'" data-id="'+ row.id +'" class="datepicker form-control" placeholder="Ngày hết hạn" data-dtp="dtp_SoZjf1">';
        }
      }
    ]

  });

  $('#tbl-active tbody').on( 'click', '.chk', function () {
    var chk     = $(this);
    var name    = chk.attr('name');
    var id      = chk.data('id');
    var value   = chk.data('value');

    $.post('/admincp/switchActive', {
        'name': name,
        'value': value,
        'id': id,
    }, function(res) {
        if (res.status === 200) {
            var checkbox = $('.chk').find('[data-id="'+ id +'"]');
            if (chk.prop('checked')) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        } else {
            swal("Lỗi!", "Hệ thống không thay đổi giá trị!", "error");
        }
    });
  });

  $('#tbl-active tbody').on( 'change', '.datepicker', function () {
    var expired = $(this);
    var name    = expired.attr('name');
    var id      = expired.data('id');
    var value   = expired.val();

    $.post('/admincp/changeExpired', {
        'name': name,
        'value': value,
        'id': id,
    }, function(res) {
        if (res.status === 200) {
          swal("Thành công!", "Thay đổi ngày hết hạn thành công!", "success");
        } else if (res.status == 400 || res.status == 401) {
          swal("Lỗi!", "Hệ thống không thay đổi giá trị!", "error");
        }
    });
  });

  // Reload data table
  $('.header-dropdown').on('click', '#tbl-reload', function() {
    table.ajax.reload();
  });

  //Datetimepicker plugin
  // $('.datepicker').bootstrapMaterialDatePicker({
  //   format: 'YYYY-MM-DD',
  //   clearButton: true,
  //   weekStart: 1,
  //   time: false,
  // }).on('change', function(e, date){
  //   // table.draw();
  // });

</script>
@endpush
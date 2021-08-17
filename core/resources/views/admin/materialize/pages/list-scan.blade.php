@extends(admin_theme().'layout')
@section('title', 'Danh sách tra cứu')

@section('content')

<div class="block-header">
  <h2>Danh sách tra cứu</h2>
</div>

 <!-- Widgets -->
 <div class="row clearfix">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <div class="info-box bg-pink hover-expand-effect">
          <div class="icon">
              <i class="material-icons">playlist_add_check</i>
          </div>
          <div class="content">
              <div class="text">Tổng lượt tra cứu</div>
              <div class="number count-to" data-from="0" data-to="{{ $dataUser }}" data-speed="15" data-fresh-interval="20"></div>
          </div>
      </div>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <div class="info-box bg-cyan hover-expand-effect">
          <div class="icon">
              <i class="material-icons">contact_phone</i>
          </div>
          <div class="content">
              <div class="text">Tổng đã gọi</div>
              <div id="called" class="number count-to" data-from="0" data-to="{{ $called }}" data-speed="1000" data-fresh-interval="20"></div>
          </div>
      </div>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <div class="info-box bg-green hover-expand-effect">
          <div class="icon">
              <i class="material-icons">person_add</i>
          </div>
          <div class="content">
              <div class="text">Đã chốt</div>
              <div id="called" class="number count-to" data-from="0" data-to="{{ $cotter }}" data-speed="1000" data-fresh-interval="20"></div>
          </div>
      </div>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <div class="info-box bg-orange hover-expand-effect">
          <div class="icon">
              <i class="material-icons">phonelink_erase</i>
          </div>
          <div class="content">
              <div class="text">Nhầm số</div>
              <div id="wrong_phone" class="number count-to" data-from="0" data-to="{{ $wrongPhone }}" data-speed="1000" data-fresh-interval="20"></div>
          </div>
      </div>
  </div>
</div>
<!-- #END# Widgets -->

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-light-blue">
                <h2>DANH SÁCH TRA CỨU</h2>
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
                    <table id="tbl-scan" class="table table-bordered table-striped table-hover dataTable"></table>
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
<script src="{{ admin_asset( 'js/scan-datatables.js') }}"></script>

<script>
  //Widgets count
  $('.count-to').countTo();

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#tbl-scan tbody').on( 'click', '.chk', function () {
    var chk     = $(this);
    var name    = chk.attr('name');
    var id      = chk.data('id');
    var value   = chk.data('value');

    $.post('/admincp/switchCall', {
        'name': name,
        'value': value,
        'id': id,
    }, function(res) {
        if (res.status === 200) {
            var checkbox = $('.chk').find('[data-id="'+ id +'"]');
            if (chk.prop('checked')) {
                document.getElementById(id).checked = true;
                document.getElementById('p'+id).checked = true;

            } else {
                document.getElementById(id).checked = false;
                document.getElementById('p'+id).checked = false;
            }

        } else {
            swal("Lỗi!", "Hệ thống không thay đổi giá trị!", "error");
        }
    });
  });

  $('#tbl-scan tbody').on( 'submit', '#frm-scan', function (e) {
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: '/admincp/changeData',
      data: $(this).serialize(),
      success: function(res) {
        if (res.status === 200) {
          swal("Chúc mừng!", "Bạn đã chỉnh sửa thành công!", "success");
          setTimeout(function () {
            location.reload();
        }, 2000);
        } else {
          swal("Lỗi!", "Lỗi không thể thay đổi nội dung!", "error");
        }
      }
    });
  });

</script>
@endpush
@extends(admin_theme().'layout')
@section('title', 'Danh sách tra cứu')

@section('content')

<!-- <div class="block-header">
    <h2>Link giới thiệu </h2>
</div> -->

<!-- Widgets -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class='col-sm-6'><p style="font-size:24px ">Link giới thiệu affiliate của bạn là: </p></div>
    <div class="col-sm-4">
        <div class="form-group">
                <input style='padding:5px;font-size:18px;color:red' class='form-control' type='text' value="{{ $link }}" />
        </div>
    </div>
    <div class='col-sm-2'>
        <div class="form-group">
            <input class='form-control btn btn-primary' type='button' value="Copy" />
        </div>
    </div>

</div>
</div>
<!-- #END# Widgets -->

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-light-blue">
                <h2>DANH SÁCH AFFILIATE</h2>
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
                    <table class="table table-striped table-list-affiliate">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Gói dịch vụ</th>
                                    <th>Giá</th>
                                    <th>Tiền affiliate</th>
                                    <th>Ngày đăng ký</th>
                                    <!-- <th>Đã gọi</th>
                                    <th>Ghi chú </th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ App\Affilate::getAffiliate($item->id,'payment') }}</td>
                                    <td>{{ App\Affilate::getAffiliate($item->id,'price') }}</td>
                                    <td>{{ App\Affilate::getAffiliate($item->id,'affiliate') == '-' ? '-' : number_format(App\Affilate::getAffiliate($item->id,'affiliate'),0) }}</td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
<!-- <script src="{{ admin_asset( 'js/affilate-datatables.js') }}"></script> -->


@endpush
@extends(admin_theme().'layout')

@section('title', 'Tổng Quan')

@section('content')

<!-- <div class="block-header">
    <h2>Tổng Quan</h2>
</div> -->

<div class="slide-owlcaurousel row m-b-20 clearfix">
    <div class="col-xs-12">
        <!-- Start hero slider/ Owl Carousel Slider -->
        <div class="tw-hero-slider owl-carousel">
            <div class="slider-1 slider-map-pattern">
                <!-- Slider arrow end -->
                <div class="slider-wrapper d-table">
                    <div class="slider-inner d-table-cell">
                        <div style="padding: 0 10px; min-width: 1000px; margin: auto;">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <img src="{{ admin_asset('images/slider/slider1.png') }}" alt="" class="slider-img img-fluid">
                                </div>
                                <!-- Col End -->
                            </div>
                            <!-- Row End -->
                            <div class="row justify-content-center text-center">
                                <div class="col-md-10">
                                    <h1 class="tw-slider-subtitle">Công Cụ Lấy Số Điện Thoại 4.0</h1>
                                    <h4 class="tw-slider-title">Face
                                        <span>Fone</span>
                                    </h4>
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- Row End -->
                        </div>
                        <!-- Container End -->
                    </div>
                    <!-- Slider Inner End -->
                </div>
                <!-- Slider Wrapper End -->
            </div>
            <!-- Slider 1 end -->

            <div class="slider-2">
                <div class="slider-arrow">
                    <img src="{{ admin_asset('images/slider/pattern_arrow2.png') }}" alt="sliderArrow1">
                    <img src="{{ admin_asset('images/slider/pattern_arrow1.png') }}" alt="sliderArrow2">
                    <img src="{{ admin_asset('images/slider/pattern_arrow3.png') }}" alt="sliderArrow3">
                </div>
                <div class="slider-wrapper d-table">
                    <div class="slider-inner d-table-cell">
                        <div style="padding: 0 10px; min-width: 1000px; margin: auto;">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="slider-content">
                                        <h1>Công Cụ Lấy Số Điện Thoại Từ
                                            <span>BigData</span>
                                        </h1>
                                        <p>Công nghệ của Facefone hoạt động dựa trên nền tảng công nghệ Big Data hỗ trợ khách hàng lấy số điện thoại nhanh chóng của bất kỳ ai trên Facebook hiện nay. Tỷ lệ chính xác lên đến 95% kể cả số điện thoại ẩn trên Facebook</p>
                                    </div>
                                </div>
                                <!-- Col end -->
                                <div class="col-md-6">
                                    <img src="{{ admin_asset('images/slider/slider2.png') }}" alt="" class="img-fluid slider-img">
                                </div>
                                <!-- col end -->
                            </div>
                            <!-- Row End -->
                        </div>
                        <!-- Container End -->
                    </div>
                    <!-- Slider Inner End -->
                </div>
                <!-- Slider Wrapper End -->
            </div>
            <!-- Slider 2 end -->

            <div class="slider-3">
                <div class="slider-arrow">
                    <img src="{{ admin_asset('images/slider/pattern_arrow2.png') }}" alt="sliderArrow1">
                    <img src="{{ admin_asset('images/slider/pattern_arrow1.png') }}" alt="sliderArrow2">
                    <img src="{{ admin_asset('images/slider/pattern_arrow3.png') }}" alt="sliderArrow3">
                </div>
                <div class="slider-wrapper d-table">
                    <div class="slider-inner d-table-cell">
                        <div style="padding: 0 10px; min-width: 1000px; margin: auto;">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <img src="{{ admin_asset('images/slider/slider3.png') }}" alt="" class="img-fluid slider-img">
                                </div>
                                <!-- Col end -->

                                <div class="col-md-6">
                                    <div class="slider-content">
                                        <h1>Tra Cứu
                                            <span>Số Điện Thoại</span></h1>
                                        <p>Đốt cháy quy trình bán hàng, telesale nhanh chóng đến khách hàng tiềm năng không chỉ của bạn mà còn cả đối thủ một cách nhanh chóng và dễ dàng</p>
                                    </div>
                                    <!-- End Slider Content -->
                                </div>
                                <!-- col end -->
                            </div>
                            <!-- Row End -->
                        </div>
                        <!-- COntainer End -->
                    </div>
                    <!-- Slider Inner End -->
                </div>
                <!-- Slider Wrapper End -->
            </div>
            <!-- Slider 3 end -->
        </div>
        <!-- End Carousel -->
    </div>
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
    <!-- Task Info -->
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-red">
                <h2>THÔNG TIN CÁ NHÂN</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <!-- <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                              <i class="material-icons">more_vert</i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                              <li><a href="javascript:void(0);" class=" waves-effect waves-block">Cập nhật</a></li>
                          </ul> -->
                        <button type="button" class="btn bg-cyan btn-block btn-xs waves-effect">Cập nhật</button>
                    </li>
                </ul>
            </div>
            <div class="body">
                <ul class="list-group">
                    <li class="list-group-item">
                        Họ tên:
                        <span class="txt-name">{{ $user->name }}
                            <span class="badge bg-pink">
                                @if ($expired['vip'] == 0)
                                Dùng thử
                                @else
                                {{ ($user->usertype == '1') ? 'VIP' : 'Dùng thử'}}
                                @endif
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item">
                        Email:
                        <span class="txt-name">{{ $user->email }}</span>
                    </li>
                    <li class="list-group-item">
                        Địa chỉ:
                        <span class="txt-name">{{ $user->location }}</span>
                    </li>
                    <li class="list-group-item">
                        Điện thoại:
                        <span class="txt-name">
                            @if ($user->phone != '')
                            <span>{{ $user->phone }}</span>
                            <button onclick="callPhone()" type="button" class="btn btn-danger waves-effect">Thay đổi</button>
                            @else
                            <!-- <span> - </span> -->
                            <button onclick="callPhone()" type="button" class="btn btn-danger waves-effect">Cập nhật</button>
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item">
                        Giới tính:
                        <span class="txt-name">
                            @if ($user->gender === 1)
                            Nam
                            @else
                            Nữ
                            @endif
                        </span>
                    </li>

                    <li class="list-group-item">
                        {{ $expired['name'] }}
                        <span class="txt-name">
                            <span>{{ $expired['value'] }}</span>
                            @if ($expired['vip'] == 0)
                            <button type="button" data-type="with-title" name="mua_vip" class="btn-primary waves-effect">Mua Vip</button>
                            @endif
                        </span>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <!-- #END# Task Info -->
    <!-- Browser Usage -->
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
        <div class="card">
            <div class="header bg-blue">
                <h2>TẢI ỨNG DỤNG EXTENSION CHO TRÌNH DUYỆT</h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-xs-6 browser-support">
                      <a target="_blank" href="https://chrome.google.com/webstore/detail/facefonevn/kojdendcdoeejdmcehlmhfgpcdhnncei?hl=en-US">
                        <div class="card">
                            <img style="max-width: 150px;" class="card-img-top" src="{{ admin_asset('images/chrome.png') }}" alt="Chrome Browser">
                            <div class="card-body">
                                <h3 class="card-title">Chrome</h3>
                            </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-xs-6 browser-support">
                      <a target="_blank" href="https://chrome.google.com/webstore/detail/facefonevn/kojdendcdoeejdmcehlmhfgpcdhnncei?hl=en-US">
                        <div class="card">
                            <img style="max-width: 150px;" class="card-img-top" src="{{ admin_asset('images/coccoc.png') }}" alt="Coc Coc Browser">
                            <div class="card-body">
                                <h3 class="card-title">Cốc Cốc</h3>
                            </div>
                        </div>
                      </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Browser Usage -->
</div>

@endsection

@push('css')

@endpush

@push('js')
<!-- Jquery CountTo Plugin Js -->
<script src="{{ admin_asset('plugins/jquery-countto/jquery.countTo.js') }}"></script>
<script src="{{ admin_asset('js/owl-carousel.2.3.0.min.js') }}"></script>

<script>
    //Widgets count
    $('.count-to').countTo();

    $('button').on('click', function() {
        var type = $(this).data('type');
        if (type === 'with-title') {
            swal({
                title: "Liên hệ qua số phone:",
                text: `
                <div class="row ct-phone">
                  <div class="col-sm-4">
                    <a href="tel:0903051557">
                      <i class="material-icons col-blue">contact_phone</i>
                      <span class="col-blue">090.3051557 (Tư vấn)</span>
                    </a>
                  </div>
                  <div class="col-sm-4">
                    <a href="tel:0903051557">
                      <i class="material-icons col-blue">contact_phone</i>
                      <span class="col-blue">090.3051557 (Tư vấn)</span>
                    </a>
                  </div>
                  <div class="col-sm-4">
                    <a href="tel:0903051557">
                      <i class="material-icons col-blue">contact_phone</i>
                      <span class="col-blue">090.3051557 (Tư vấn)</span>
                    </a>
                  </div>
                </div>
              `,
                html: true
            });
        }
    });

    $(".tw-hero-slider").owlCarousel({
      items: 1,
      loop: true,
      autoplay: true,
      nav: true,
      dots: false,
      autoplayTimeout: 8000,
      autoplayHoverPause: true,
      mouseDrag: false,
      smartSpeed: 1100,
      navText: ['<i class="material-icons dp48">arrow_back</i>', '<i class="material-icons dp48">arrow_forward</i>'],
    });

</script>
@endpush
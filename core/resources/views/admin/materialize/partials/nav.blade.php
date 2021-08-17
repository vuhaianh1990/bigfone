<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
  <!-- User Info -->

  <!-- #User Info -->
  <!-- Menu -->
  <div class="menu">
    <ul class="list">
      <li class="header">Menu</li>
      <li>
        <a href="{{ admin_route('home') }}">
          <i class="material-icons">home</i>
          <span>Tổng quan</span>
        </a>
      </li>
      <li>
        <a href="{{ admin_route('listScan') }}">
          <i class="material-icons">chrome_reader_mode</i>
          <span>Danh sách tra cứu</span>
        </a>
      </li>
      <li>
            <a href="javascript:void(0);" class="menu-toggle waves-effect waves-block toggled">
                <i class="material-icons">view_list</i>
                <span>Thanh toán</span>
            </a>
            <ul class="ml-menu" style="display: block;">
                <li>
                    <a href="/admincp/payment" class=" waves-effect waves-block">Gói dịch vụ</a>
                </li>
                <li>
                    <a href="/admincp/transaction" class=" waves-effect waves-block">Lịch sử giao dịch</a>
                </li>
            </ul>
        </li>
      @if(\AV_Core\Models\User::isAdmin() === TRUE)
      <li>
        <a href="{{ superadmin_route('list-transaction') }}">
          <i class="material-icons">money</i>
          <span>Quản lý đơn hàng</span>
        </a>
      </li>
      @endif
      <li>
        <a href="{{ admin_route('management_affilate') }}">
          <i class="material-icons">money</i>
          <span>Kiếm tiền Affiliate</span>
        </a>
      </li>
      {{-- <li>
        <a href="{{ admin_route('howtouse') }}">
          <i class="material-icons">assignment_turned_in</i>
          <span>Hướng dẫn sử dụng</span>
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">content_copy</i>
          <span>Blank</span>
        </a>
        <ul class="ml-menu">
          <li>
            <a href="#">Danh sách</a>
          </li>
        </ul>
      </li> --}}
      <li class="header">Liên Hệ</li>
      <li class="bg-cyan">
        <a href="tel:0986863920">
          <i class="material-icons col-white">contact_phone</i>
          <span class="col-white">0XX XXX XXX (Tư vấn)</span>
        </a>
      </li>
      <li class="bg-light-blue">
        <a href="tel:0986863920">
          <i class="material-icons col-white">contact_phone</i>
          <span class="col-white">0XX XXX XXX (Zalo)</span>
        </a>
      </li>
      <li class="bg-blue">
        <a href="tel:0986863920">
          <i class="material-icons col-white">contact_phone</i>
          <span class="col-white">0XX XXX XXX (Viber)</span>
        </a>
      </li>
    </ul>
  </div>
  <!-- #Menu -->
  <!-- Footer -->
  <div class="legal">
    <div class="copyright">
      &copy; {{ date('Y') }} <a href="javascript:void(0);">Copyright&copy; by Facefone</a>.
    </div>
    <!-- <div class="version">
      <b>Version: </b> 1.0
    </div> -->
  </div>
  <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->
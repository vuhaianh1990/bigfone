$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

var table = $('#tbl-scan').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    dom: 'lBfrtip',
    buttons: [

        {
          extend: 'excel',
        exportOptions: {
          columns: [0,1,2,3,4,5,6],
          format: {
            body: function(data, row, column, node) {
              var value = $('<span>' + data + '</span>').text();
              
              return value;
            }
          }
        },
          filename: function(){
              var d = new Date();
              // TODO ... dd/mm/yyyy hh:mm:ss.
              return document.title + ' ' +d.toISOString();
          }
      },
    ],
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
      'url': "/admincp/getListScan",
      'data': function(d) {
        d.date_start = $('input[name=date_start]').val();
        d.date_end = $('input[name=date_end]').val();
      }
    },
    columns: [
      {
        "className":      'details-control',
        "orderable":      false,
        "searchable":     false,
        "data":           null,
        "defaultContent": ''
      },
      {
        'title': 'Ngày quét',
        'data': 'created_at'
      },{
        'title': 'Tên',
        'data': 'name'
      },{
        'title': 'Điện thoại',
        'data': 'phone',
        'render': function(data, type, row) {
          if (!row.phone) return '-';
          return '+'+row.phone
        }
      },
      // {
      //   'title': 'Email',
      //   'data': 'email',
      //   'render': function(data, type, row) {
      //     if (!row.email) return '-';
      //     return row.email
      //   }
      // },
      {
        'title': 'link FB',
        'data': 'link',
        'render': function(data, type, row) {
          if (row.link) {
            return '<a href="'+ row.link +'" target="_blank">'+ row.link +'</a>';
          } else {
            return '-';
          }
        }
      },{
        'title': 'Địa chỉ',
        'data': 'location',
        'render': function(data, type, row) {
          if (!row.location) return '-';
          return row.location;
        }
      },{
        'title': 'Giới tính',
        'data': 'gender',
        'render': function(data, type, row) {
          if (row.gender === 1) {
            return 'Nam';
          } else if (row.gender === 0) {
            return 'Nữ';
          } else {
            return '-';
          }
        }
      },{
        'title': 'Đã gọi',
        'data': 'called',
        'render': function(data, type, row) {
          var checked = '';
          if (row.called == 1) {
            checked = 'checked';
          }

          return '<div class="switch"><label><input type="checkbox" name="called" class="chk" id="'+ row.id +'" data-id="'+ row.id +'" data-value="'+ row.called +'" '+ checked +'><span class="lever switch-col-blue"></span></label></div>';
        }
      },{
        'title': 'Nhầm số',
        'data': 'wrong_phone',
        'render': function(data, type, row) {
          var checked = '';
          if (row.wrong_phone == 1) {
            checked = 'checked';
          }

          return '<div class="switch"><label><input type="checkbox" name="wrong_phone" class="chk" id="'+ row.id +'" data-id="'+ row.id +'" data-value="'+ row.wrong_phone +'" '+ checked +'><span class="lever switch-col-orange"></span></label></div>';
        }
      },{
        'title': 'Đã chốt',
        'data': 'cotter',
        'render': function(data, type, row) {
          var checked = '';
          if (row.cotter == 1) {
            checked = 'checked';
          }

          return '<div class="switch"><label><input type="checkbox" name="cotter" class="chk" id="'+ row.id +'" data-id="'+ row.id +'" data-value="'+ row.cotter +'" '+ checked +'><span class="lever switch-col-green"></span></label></div>';
        }
      },{
        'title': 'Xem',
        'searchable': false,
        'orderable':false,
        'render': function(data, type, row) {
          var avatar = row.avatar;
          if (avatar == '' || avatar === null || typeof avatar === 'undefined') {
            avatar = '/themes/materialize/images/user.svg';
          }

          var called = row.called;
          if (called) {
            called = 'checked';
          }

          var wrong_phone = row.wrong_phone;
          if (wrong_phone) {
            wrong_phone = 'checked';
          }

          var cotter = row.cotter;
          if (cotter) {
            cotter = 'checked';
          }

          function getGenderSelected(gender) {
            if (row.gender === gender) return 'selected';
          }

          var email = row.email;
          if (email === null || typeof email === 'undefined') {
            email = '';
          }

          var health_care = row.health_care;
          if (health_care === null || typeof health_care === 'undefined') {
            health_care = '';
          }

          var date_health_care = row.date_health_care;
          if (date_health_care === null || typeof date_health_care === 'undefined') {
            date_health_care = '';
          }

          var location = row.location;
          if (location === null || typeof location === 'undefined') {
            location = '';
          }

          var link = row.link;
          if (link === null || typeof link === 'undefined') {
            link = '';
          }

          var note = row.note;
          if (note === null || typeof note === 'undefined') {
            note = '';
          }

          var work = row.work;
          if (work === null || typeof work === 'undefined') {
            work = '';
          }

          var phone = row.phone;
          if (phone === null || typeof phone === 'undefined') {
            phone = '';
          }

          return '<button type="button" data-toggle="modal" data-target="#editorModal'+ row.id +'" class="btn btn-info btn-view"><i class="material-icons">remove_red_eye</i></button>'
              + '<div class="modal fade in" id="editorModal'+ row.id + '" tabindex="-1" role="dialog">'
              + '  <form name="frm-scan" id="frm-scan">'
              + '    <div class="modal-dialog modal-lg" role="document">'
              + '        <div class="modal-content">'
              + '            <div class="modal-header">'
              + '                <h4 class="modal-title" id="largeModalLabel">'+ row.name + '</h4>'
              + '            </div>'
              + '            <div class="modal-body">'
              + ''
              + '              <div class="modal-avatar">'
              + '                <img src="' + avatar +'" alt="' + row.name +'">'
              + '              </div>'
              + ''
              + '              <div class="row clearfix">'
              + '                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">'
              + '                  <div class="form-group">'
              + '                      <div class="switch">'
              + '                        <label><input type="checkbox" name="called" class="chk" id="p'+ row.id +'" data-id="'+ row.id + '" data-value="'+ row.called + '" value="'+ row.called + '" '+ called + '><span class="lever switch-col-blue"></span></label>'
              + '                      Đã gọi'
              + '                      </div>'
              + '                  </div>'
              + '                </div>'
              + '                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">'
              + '                  <div class="form-group">'
              + '                      <div class="switch">'
              + '                        <label><input type="checkbox" name="wrong_phone" class="chk" id="p'+ row.id +'" data-id="'+ row.id + '" data-value="'+ row.wrong_phone + '" value="'+ row.wrong_phone + '" '+ wrong_phone + '><span class="lever switch-col-orange"></span></label>'
              + '                        Nhầm số'
              + '                      </div>'
              + '                  </div>'
              + '                </div>'
              + '                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">'
              + '                  <div class="form-group">'
              + '                      <div class="switch">'
              + '                        <label><input type="checkbox" name="cotter" class="chk" id="p'+ row.id +'" data-id="'+ row.id + '" data-value="'+ row.cotter + '" value="'+ row.cotter + '" '+ cotter + '><span class="lever switch-col-green"></span></label>'
              + '                        Nhầm số'
              + '                      </div>'
              + '                  </div>'
              + '                </div>'
              + '              </div>'
              + ''
              + '              <div class="row clearfix">'
              + '                <div class="col-xs-4">'
              + '                    <label for="name">Tên</label>'
              + '                    <div class="form-group">'
              + '                      <div class="form-line">'
              + '                        <input type="text" name="name" id="name" class="form-control" placeholder="Tên" value="'+ row.name + '">'
              + '                      </div>'
              + '                    </div>'
              + '                </div>'
              + ''
              + '                <div class="col-xs-4">'
              + '                    <label for="gender">Giới tính</label>'
              + '                    <div class="form-group">'
              + '                      <div class="form-line">'
              + '                        <select name="gender" class="form-control" id="gender">'
              + '                            <option value="1" '+ getGenderSelected(1) + '>Nam</option>'
              + '                            <option value="0" '+ getGenderSelected(0) + '>Nữ</option>'
              + '                        </select>'
              + '                      </div>'
              + '                    </div>'
              + '                </div>'
              + ''
              + '                <div class="col-xs-4">'
              + '                    <label for="phone">Số Điện thoại</label>'
              + '                    <div class="form-group">'
              + '                      <div class="form-line">'
              + '                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Số điện thoại" value="'+ phone + '" disabled="">'
              + '                      </div>'
              + '                    </div>'
              + '                </div>'
              + '              </div>'
              + ''
              + '              <div class="row clearfix">'
              + '                <div class="col-xs-6">'
              + '                  <label for="email">Email</label>'
              + '                  <div class="form-group">'
              + '                    <div class="form-line">'
              + '                      <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="'+ email + '">'
              + '                    </div>'
              + '                  </div>'
              + '                </div>'
              + '                <div class="col-xs-6">'
              + '                  <label for="created_at">Ngày scan</label>'
              + '                  <div class="form-group">'
              + '                    <div class="form-line">'
              + '                      <input type="text" disabled id="created_at" class="form-control" placeholder="Ngày Scan" value="'+ row.created_at + '">'
              + '                    </div>'
              + '                  </div>'
              + '                </div>'
              + '              </div>'
              + ''
              + '              <div class="row clearfix">'
              + '                <div class="col-xs-6">'
              + '                  <label for="location">Khu vực</label>'
              + '                  <div class="form-group">'
              + '                    <div class="form-line">'
              + '                      <input type="text" name="location" id="location" class="form-control" placeholder="Khu vực" value="'+ location + '">'
              + '                    </div>'
              + '                  </div>'
              + '                </div>'
              + '                <div class="col-xs-6">'
              + '                  <label for="work">Công việc</label>'
              + '                  <div class="form-group">'
              + '                    <div class="form-line">'
              + '                      <input type="text" name="work" id="work" class="form-control" placeholder="Công việc" value="'+ work + '">'
              + '                    </div>'
              + '                  </div>'
              + '                </div>'
              + '              </div>'
              + ''
              + '              <div class="row clearfix">'
              + '                <div class="col-xs-12">'
              + '                  <label for="link">Link liên kết</label>'
              + '                  <div class="form-group">'
              + '                    <div class="form-line">'
              + '                      <a href="'+ link +'" target="_blank">'+ link +'</a>'
              + '                    </div>'
              + '                  </div>'
              + '                </div>'
              + '              </div>'
              + ''
              + '              <div class="row clearfix">'
              + '                <div class="col-xs-12">'
              + '                  <label for="date_health_care">Ngày chăm sóc</label>'
              + '                  <div class="form-group">'
              + '                    <div class="form-line">'
              + '                      <input type="date" name="date_health_care" id="date_health_care" class="form-control" placeholder="Ngày chăm sóc" value="'+ date_health_care + '">'
              + '                    </div>'
              + '                  </div>'
              + '                </div>'
              + '              </div>'
              + ''
              + '              <div class="row clearfix">'
              + '                <div class="col-xs-12">'
              + '                  <label for="health_care">Nội dung chăm sóc</label>'
              + '                  <div class="form-group">'
              + '                    <div class="form-line">'
              + '                      <textarea name="health_care" class="form-control" placeholder="Nội dung chăm sóc">'+ health_care + '</textarea>'
              + '                    </div>'
              + '                  </div>'
              + '                </div>'
              + '              </div>'
              + ''
              + '              <div class="row clearfix">'
              + '                <div class="col-xs-12">'
              + '                  <label for="note">Chú thích</label>'
              + '                  <div class="form-group">'
              + '                    <div class="form-line">'
              + '                      <textarea name="note" class="form-control" placeholder="Chú thích">'+ note + '</textarea>'
              + '                    </div>'
              + '                  </div>'
              + '                </div>'
              + '              </div>'
              + '              <input type="hidden" name="id" value="'+ row.id + '">'
              + '            </div>'
              + '            <div class="modal-footer">'
              + '                <button type="submit" class="btn btn-success">Lưu</button>'
              + '                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Đóng</button>'
              + '            </div>'
              + '        </div>'
              + '    </div>'
              + '  </form>'
              + '</div>';

        }
      }
    ]

});

//Datetimepicker plugin
$('.datepicker').bootstrapMaterialDatePicker({
  format: 'YYYY-MM-DD',
  clearButton: true,
  weekStart: 1,
  time: false,
}).on('change', function(e, date){
  table.draw();
});



// Add event listener for opening and closing details
function format ( row ) {
  date_health_care = row.date_health_care;
  if (date_health_care == '' || date_health_care === null || typeof date_health_care === 'undefined') {
    date_health_care = '-';
  }

  health_care = row.health_care;
  if (health_care == '' || health_care === null || typeof health_care === 'undefined') {
    health_care = '-';
  } else {
    health_care = '<pre>'+ health_care +'</pre>';
  }

  html =  '<table class="table tbl-scan-detail table-bordered table-striped table-hover no-footer">'
        + '  <tr>'
        + '      <th class="col-md-3">Ngày chăm sóc:</td>'
        + '      <td class="col-md-9">'+ date_health_care +'</td>'
        + '  </tr>'
        + '  <tr>'
        + '      <th class="col-md-3">Nội dung chăm sóc:</td>'
        + '      <td class="col-md-9">'+ health_care +'</td>'
        + '  </tr>'
        + '</table>';
  return html;
}

// Array to track the ids of the details displayed rows
var detailRows = [];

$('#tbl-scan tbody').on( 'click', 'tr td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );
    var idx = $.inArray( tr.attr('id'), detailRows );

    if ( row.child.isShown() ) {
        tr.removeClass( 'details' );
        row.child.hide();

        // Remove from the 'open' array
        detailRows.splice( idx, 1 );
    }
    else {
        tr.addClass( 'details' );
        row.child( format( row.data() ) ).show();

        // Add to the 'open' array
        if ( idx === -1 ) {
            detailRows.push( tr.attr('id') );
        }
    }
} );

// On each draw, loop over the `detailRows` array and show any child rows
table.on( 'draw', function () {
    $.each( detailRows, function ( i, id ) {
        $('#'+id+' td.details-control').trigger( 'click' );
    } );
} );

// Reload data table
$('.header-dropdown').on('click', '#tbl-reload', function() {
  table.ajax.reload();
});
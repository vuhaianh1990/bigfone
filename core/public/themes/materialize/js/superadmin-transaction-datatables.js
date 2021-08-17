$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  var table = $('#tbl-admin-transaction').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      dom: 'lBfrtip',
      buttons: [
          // 'copy', 'csv', 'excel', 'pdf', 'print',
          // {
          //   extend: 'print',
          //     text: 'Print current page',
          //     exportOptions: {
          //       columns: [0,1,2,3,4,5,6,7,8,9]
          //     }
          // },
          // {
          //   text: 'JSON',
          //   action: function ( e, dt, button, config ) {
          //       var data = dt.buttons.exportData();
          //       $.fn.dataTable.fileSave(
          //           new Blob( [ JSON.stringify( data ) ] ),
          //           'Export.json'
          //       );
          //   }
          // },
          {
            text: 'CSV',
            action: function(e, dt, button, config) {
              dt.one('preXhr', function(e, s, data) {
                data.length = -1;
              }).one('draw', function(e, settings, json, xhr) {
                var pdfButtonConfig = $.fn.DataTable.ext.buttons.csvHtml5;
                var addOptions = { exportOptions: { "columns" : ":visible" }};
  
                $.extend(true,pdfButtonConfig,addOptions);
                pdfButtonConfig.action(e, dt, button, pdfButtonConfig);
              }).draw();
            }
          }
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
        'url': "/admincp/get-list-transaction",
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
        },{
            'title': 'Mã giao dịch',
            'data': 'id'
        },{
            'title': 'Điện thoại',
            'data': 'phone'
        },{
            'title': 'Gói dịch vụ',
            'data': 'name_payment',
        },{
            'title': 'Giá',
            'data': 'price'
        },{
            'title': 'Trạng thái',
            'data': 'status',
            'render': function(data, type, row) {
                if (row.status == 0) {
                    return 'Chờ duyệt';
                } else{
                    return 'Đã duyệt';
                } 
            }
        },{
            'title':'Ngày tạo',
            'data' : 'created_at'
        },{
            'title': 'Duyệt',
            'render': function(data, type, row) {
                if(row.status == 0)
                    return "<button type='button' data-id='"+row.id+"' class='btn btn-danger waves-effect btn_accept_transaction'>Duyệt</button>";
                else
                    return '';
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
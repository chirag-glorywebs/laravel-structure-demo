@extends('layouts.admin.layout')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Error Logs</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Error Logs</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Error Logs</h3>
          </div>

          <!-- /.card-header -->
          <div class="card-body">

            <table id="errorLogDatatable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">#</th>
                  <th width="20%">URL</th>
                  <th width="45%">Error</th>
                  <th width="15%">Created By</th>
                  <th width="15%">Created At</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              {{--<tfoot>
                <tr>
                  <th>#</th>
                  <th>URL</th>
                  <th>Error</th>
                  <th>Created By</th>
                  <th>Created At</th>
                </tr>
              </tfoot>--}}
            </table>

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
<!-- /.content -->

<script>
  var APP_URL = {!! json_encode(url('/')) !!};

  $(function () {
    var dataTable = $('#errorLogDatatable').DataTable({
          processing: false,
          serverSide: true,
          ajax: {
              url: '/admin/api/error-logs/list'
          },
          order:[],
          columns: [
            {
              sTitle: "#",
              data: "error_id",
              name: "error_id",
              orderable: false,
              render: function(data, type, row, meta) {
                  var pageinfo = dataTable.page.info();
                  var currentpage = (pageinfo.page) * pageinfo.length;
                  var display_number = (meta.row + 1) + currentpage;
                  return display_number;
              }
            },
            {
              data: "base_url",
              name: "base_url",
              orderable: false,
              searchable: true,
              render: function(data, type, row, meta) {
                var str = "";
                if(data){
                    str += '<div class="contact_name">';
                      str += '<div class="">Remote Address: <b>'+row.remote_addr+'</b></div>';
                      str += '<div class="">'+data+'</div>';
                    str += '</div>';
                } else {
                  str += 'N/A';
                }
                return str;
              }
            },
            {
              data: "error_type",
              name: "error_type",
              orderable: false,
              searchable: true,
              render: function(data, type, row, meta) {
                var str = "";
                if(data){
                    str += '<div class="error_msg">';
                      str += '<div class=""><b>'+row.error_type+'</b></div>';
                      str += '<div class="">'+data+'</div>';
                    str += '</div>';
                } else {
                  str += 'N/A';
                }
                return str;
              }
            },
            {
              sTitle: "Created By",
              data: "created_by",
              name: "created_by",
              orderable: false,
              searchable: true,
              render: function(data, type, row, meta) {
                  return data;
              }
            },
            {
              sTitle: "Created At",
              data: "created_at",
              name: "created_at",
              orderable: false,
              searchable: false,
              render: function(data, type, row, meta) {
                // var str = "";
                    // str = (data) ? formatDate(new Date(data), 'datetime') : 'N/A';
                return data;

              }
            }
          ],
          fnRowCallback: function( nRow, aData, iDisplayIndex ) {
              return nRow;
          },
          fnDrawCallback: function( oSettings ) {

          }
      });
  });

</script>

@stop

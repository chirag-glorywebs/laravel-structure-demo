@extends('layouts.admin.layout')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">User Management</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/admin">Home</a></li>
          <li class="breadcrumb-item active">User</li>
          <li class="breadcrumb-item active">User list</li>
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
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title float-none float-sm-left mb-3">User List</h3>
              <a href="{{ route('user.create') }}">
              <div class="btn btn-primary float-sm-right">
                <i class="fas fa-user fa-lg mr-2"></i>
                Add User
              </div>
                </a>
            </div>

            <div class="card-body">
              <!-- <div class="col-sm-3"> -->
                <div class="form-group">
                  <label for="user_type"> Select User Type </label>
                  <select class="form-control select2" name="user_type" id="selectedUserType">
                     <option value="">---Select User Type---</option>
                      @if(isset($userTypeList) && isset($userTypeList))
                        @foreach($userTypeList as $key => $value)
                          <option value="{{$key}}" {{( isset($data->user_type) && $data->user_type === $key || old('user_type') == $key) ? 'selected' : '' }}> {{$value}} </option>
                        @endforeach
                      @endif
                  </select>
                  @if ($errors->has('user_type'))
                    <div class="invalid-feedback">
                      <i class="fa fa-times-circle-o"></i> {{ $errors->first('user_type') }}
                    </div>
                  @endif
                </div>
              <!-- </div> -->
              <div class="table-overflow">
                <table id="userdatatable" class="table table-bordered table-striped display responsive nowrap">
                  <thead>
                  <tr>
                    <th width="5%">#</th>
                    <th width="30%">Name</th>
                    <th width="30%">Email</th>
                    <th width="30%">User Type</th>
                    <th width="25%">Created At</th>
                    <th width="10%">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>

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
    $(function () {
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })

        var dataTable = $('#userdatatable').DataTable({
            processing: false,
            lengthChange: true,
            searching: true,
            ordering: true,
            serverSide: true,
            info: true,
            responsive: false,
            language: {
                emptyTable: "No User Found"
            },
            ajax: {
                url: "{{ route('user.index') }}",
                data: function(data){
                    data.filterUserType = $('#selectedUserType').val();
                }
            },
            order:[[1, "asc" ]],
            columns: [
                {
                    sTitle: "#",
                    data: "user_id",
                    name: "user_id",
                    orderable: false,
                    render: function(data, type, row, meta) {
                        var pageinfo = dataTable.page.info();
                        var currentpage = (pageinfo.page) * pageinfo.length;
                        var display_number = (meta.row + 1) + currentpage;
                        return display_number;
                    }
                },
                {
                    sTitle: "Name",
                    data: "full_name",
                    name: "full_name",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row, meta) {

                        var str = "";
                        str += '<div class="">';
                        str += '<div class="mr-2 float-left">';
                        if(row.profile_picture){
                            var imgPath = '{{ route("adminimage.displayUserImage",["foldername"=> "user_images","filename" => ":profile_picture"])}}';
                            imgPath = imgPath.replace(':profile_picture', row.profile_picture);
                            str += '<img class="user-image" width="42" height="42" id="imageview" src="'+imgPath+'">';
                        } else {
                            str += '<img class="user-image" width="42" height="42" src="/admin-panel/img/avatar5.png">';
                        }
                        str += '</div>';

                        str += '<div class="float-left">';
                        str += '<div class="">';
                            str +=  '<span class="mr-2 text-bold">'+row.full_name+'</span>';
                        str += '</div>';
                        str += '<div class="text-muted text-sm">'+row.user_type+'</div>';
                        str += '</div>';
                        str += '</div>';
                        return str;
                    }
                },
                {
                    sTitle: "Email",
                    data: "email",
                    name: "email",
                    orderable: true,
                    searchable: true
                },
                {
                    sTitle: "User Type",
                    data: "user_type",
                    name: "user_type",
                    orderable: true,
                    searchable: true,
                    /*render: function(data, type, row, meta) {
                        // debugger;
                        var str = "";
                        str += '<div class="">';
                            str += '<div class="float-left">';
                                str += '<div class="text-muted text-sm">'+row.user_type+'</div>';
                            str += '</div>';
                        str += '</div>';
                        return str;
                    }*/
                },
                {
                    sTitle: "Created At",
                    data: "display_created_at",
                    name: "created_at",
                    orderable: true,
                    searchable: true
                },
                {
                    sTitle: "Action",
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        var edit_url = '{{ route("user.edit", ":user_id") }}';
                        edit_url = edit_url.replace(':user_id', row.user_id);
                        var str = "";
                        str += '<div class="btn-group">';
                        if(row.status == 1){
                        str += '<a title="Status" id="'+row.user_id+'" class="btn btn-success status_active" href="javascript:;" data-id="'+row.user_id+'"><i class="fas fa-check-circle"></i></a>';
                        }else{
                        str += '<a title="Status" id="'+row.user_id+'" class="btn btn-default status_active" href="javascript:;" data-id="'+row.user_id+'"><i class="fas fa-ban"></i></a>';
                        }
                        str+= '<a title="Edit" id="'+row.user_id+'" class="btn btn-warning edit_icon icon user-edit" href="'+edit_url+'"><i class="fas fa-edit"></i></a>';
                        str += '<a title="Delete" id="'+row.user_id+'" class="btn btn-danger delete_icon icon delete_record" data-tooltip="Delete" href="javascript:;" data-id="'+row.user_id+'" data-toggle="modal" data-target="#modal-sm-'+row.user_id+'"><i class="fas fa-trash"></i></a>'
                        str += '</div>';
                        return str;
                    }
                }
            ],
            fnRowCallback: function( nRow, aData, iDisplayIndex ) {
                return nRow;
            },
            fnDrawCallback: function( oSettings ) {
                // Delete Record
                $('.status_active').on( 'click', function (e) {
                let statusId = $(this).attr("data-id");
                let url = "user/active-deactive";
                self.confirmStatus(statusId, url, dataTable);
                });
                $('.delete_record').on( 'click', function (e) {
                let delId = $(this).attr("data-id");
                let url = "user/"+delId;
                self.confirmDelete(delId, url, dataTable);
                });
            },
            fnInitComplete: function(oSettings, json) {
            },
            createdRow: function( row, data, dataIndex ) {
            }
        });

        // Dropdown FilterBy User Type
        $("#userdatatable_filter.dataTables_filter").append($("#selectedUserType"));
        $("#selectedUserType").change(function (event) {
            // console.log(event.target.value);
            dataTable.draw();
        });

    });


// $(document).ready(function() {
//   $("#user_type").change(function() {
//     var url = "{{ route('userType-wise', [ 'user' => '_USERTYPE_' ]) }}";
//     url = url.replace('_USERTYPE_', $(this).val());
//     alert(url);
//     $.ajax({
//       headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//       },
//       url: url,
//       success: function(result) {
//         if(result.length == 0) {
//           var tr = document.createElement('tr');
//           tr.innerHTML = '<td colspan="2" class="text-center">No transaction found in the selected month</td>';
//           $('#transact').html($(tr));
//           return;
//         }

//         var tBody = $('#transact')[0];
//         tBody.innerHTML = '';
//         var trTmpl = $('#transact-tmpl')[0].children[0];

//         for(var i = 0; i < result.length; i++) {
//           var tr = trTmpl.cloneNode(true);
//           tr.getElementsByClassName('wallet-item-title')[0].innerHTML = result[i].detail;
//           tr.getElementsByClassName('wallet-item-date')[0].innerHTML = result[i].date;
//           var tdAmt = tr.getElementsByClassName('wallet-price')[0];
//           tdAmt.innerHTML = result[i].credit_number;

//           if(result[i].transaction_type == 'credit')
//             tdAmt.className += ' plus';

//           tBody.appendChild(tr);
//         }
//       }
//     });
//   });
// });
</script>

@stop

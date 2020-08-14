@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Employee')
@push('links')
    <link rel="stylesheet" href="{{ URL::asset('public/company/slider.css') }}">
@endpush
<div class="container">

    <!-- Info boxes -->
    <div class="row">
        <div class="col-12" style="margin-top: -40px;">
            <a href="{{ route('company.employee.create') }}" class="btn btn-info btn-sm " data-id=""
               style="float: right;">
                <i class="fa fa-plus"></i> Add New
            </a>
            <a href="#" data-toggle="modal" data-typeid="" data-target=".import_excel"
                       class="btn btn-info btn-sm openimportmodal" data-id="" style="float: right; margin-right: 5px;">
                        <i class="fa fa-upload" aria-hidden="true"></i> Import
            </a>
            <span class="clicktosearch " style="float: right;margin-right: 10px;"><button class="btn btn-sm btn-info">Click To Search <i
                        class="fa fa-search"></i></button></span>

        </div>
        <div class="col-12 ">
            <div class="card card-info card-outline displaybl" style=" display: none;">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="form-group m-form__group  row ">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label style="color: #000;">Filter Type</label>
                                    <select class="form-control filter_type" id="sel1">

                                        <option value="status"
                                                @if(isset($filter_type) && $filter_type == "status") selected @endif>
                                            Status
                                        </option>
                                        <option value="qualification"
                                                @if(isset($filter_type) && $filter_type == "qualification") selected @endif>
                                            Qualification
                                        </option>
                                        <option value="department"
                                                @if(isset($filter_type) && $filter_type == "date_of_joining") selected @endif>
                                            Department
                                        </option>
                                        <option value="date_of_joining"
                                                @if(isset($filter_type) && $filter_type == "date_of_joining") selected @endif>
                                            Date of Joining
                                        </option>
                                        <option value="salary"
                                                @if(isset($filter_type) && $filter_type == "salary") selected @endif>
                                            Salary Base
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label style="color: #000;">Search</label>
                                     <span class="rangediv" style="display: none">
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <div id="slider-range"></div>
                                        </div>
                                    </div>
                                    <div class="row slider-labels">
                                        <div class="col-xs-6 caption">
                                            <strong>Min:</strong> <span id="slider-range-value1"></span>
                                        </div>
                                        <div class="col-xs-6 text-right caption">
                                            <strong>, Max:</strong> <span id="slider-range-value2"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form>
                                                <input type="hidden" name="min-value" class="minsalary" value="">
                                                <input type="hidden" name="max-value" class="maxsalary" value="">
                                            </form>
                                        </div>
                                    </div>
                                </span>
                                    <span class="selectdiv"  >

                                    <select class="form-control searchvalue" id="status" name="searchvalue">
                                        <option value="">Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                        </span>
                                    <span class="filterdiv"style="display: none" >
                                        <input type="date" name="joiningdate" class="form-control joiningdate">
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <button class="btn btn-success btn-sm searchdata "
                                            style="margin-top: 33px;"><i class="fa fa-search"></i> Search <span
                                            class="spinner"></span>
                                    </button>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm resetbutton"
                                       style="margin-top: 33px;margin-left: 5px;cursor: pointer; ">
                                        <i class="fa fa-refresh resetspinner" aria-hidden="true"></i> Reset
                                    </a>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="card  card-outline">

                <div class="card-body">
                    <!-- /.card-header -->
                    <table id="employee" class="table table-bordered table-hover" style="background: #fff;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            {{--<th>City</th>--}}
                            <th>Create Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <!-- /.card-body -->
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.col -->
        </div>

    </div>
    <!-- /.row -->
</div>
<!--/. container-fluid -->
<div class="modal fade add_modal filterselect2" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Large Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade import_excel" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 15px;">
                <h5 class="modal-title">Import Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form  autocorrect="off" action="{{ route('company.employee.importexcel') }}" autocomplete="off" method="post" class="form-horizontal form-bordered importexcel">
                    {{ csrf_field() }}

                   
                    <div class="row">
                        <div class="col-md-12">
                            
                    <div class="form-group">
                        <label></label>
                        <a class="link-unstyled" download="" href="{{ URL::asset('public/company/employee/sample/sample.xlsx') }}" title="">
                    <i class="fa fa-cloud-download pr10"></i> Sample Sheet </a>
                    </div>
                            <div class="form-group">
                                 <label for="customFile">Salect File <span class="text-danger">*</span></label> 

                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" name="file" required="" id="customFile">
                                  <label class="custom-file-label" for="customFile">Import Excel File</label>
                                </div>
                              </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary  submitbutton pull-right"> Submit <span class="spinner"></span></button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@push('links')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
@endpush
@push('script')
    <script src="{{ URL::asset('public/js/slider.js') }}"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script>
        function reloadtable() {
            $('.fa-refresh').removeClass('fa-spin');
            $('#employee').DataTable().ajax.reload();
        }
        $('body').on('click', '.clicktosearch', function () {
            $('.displaybl').toggle("slide");
        })
        $('body').on('change', '.filter_type', function () {
            var type = $(this).val();
            $.ajax({
                url: "{{ route('company.employee.getfilter')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {type: type},
                success: function (data) {
                    if(type == 'date_of_joining') {
                        $('.filterdiv').show();
                        $(".selectdiv").hide();
                        //$('.filterdiv').html(data);
                    } else if(type == 'salary'){
                        $('.rangediv').show();
                        $('.searchvalue').val('');
                        $('.filterdiv').hide();
                        $(".selectdiv").hide();
                    }else{
                        $('.filterdiv').hide();
                         $('.rangediv').hide();
                            $(".selectdiv").show();
                        $( 'select[name="searchvalue"]' ).html( data );
                    }



                },
            });
        });
        $('body').on('click', '.resetbutton', function (e) {
            e.preventDefault();
            $('.searchvalue').val('');
            $('.joiningdate').val('');
            $('.minsalary').val('');
            $('.maxsalary').val('');
            $('.filter_type').prop('selectedIndex', 0);
            $('.filterdiv').hide();
                         $('.rangediv').hide();
                            $(".selectdiv").show();
            $('.fa-refresh').addClass('fa-spin');
            reloadtable();
        })
        $(function () {
            /* datatable */
            //function loaddatatable(){
            $("#employee").DataTable({
                "responsive": true,
                "autoWidth": false,
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    'url': "{{ route('company.employee.getall') }}",
                    'type': 'POST',
                    'data': function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.filter_type = $('.filter_type').val();
                        d.searchvalue = $('.searchvalue').val();
                        d.date_of_joining = $('.joiningdate').val();
                        d.minsalary = $('.minsalary').val();
                        d.maxsalary = $('.maxsalary').val();

                    }
                    /*  complete: function () {
                          $('[data-toggle="tooltip"]').tooltip();
                      },*/
                },
                columns: [
                    {data: 'DT_RowIndex', "orderable": false},
                    {data: 'image'},
                    {data: 'fullname'},
                    {data: 'email'},
                    {data: 'phone'},
                    //{data: 'city'},
                    {data: 'created_at'},
                    {data: 'status'},
                    {data: 'action', orderable: false, 'width':'25%'},
                ]
            });

            // }
            /*filter*/
            $('.searchdata').click(function () {
                event.preventDefault();
                $("#employee").DataTable().ajax.reload()
            })
        });
        /********* add new employee ********/
        $('body').on('click', '.openaddmodal', function () {
            var id = $(this).data('id');
            if (id == '') {
                $('.modal-title').text('Add Employee');
            } else {
                $('.modal-title').text('Edit Employee');
            }
            $.ajax({
                url: "{{ route('company.employee.getmodal')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {id: id},
                success: function (data) {
                    $('.modal-body').html(data);
                    $(".formsubmit").validate({
                        rules: {
                            name: {
                                require: true,
                                maxlength: 50
                            },
                            lastname: {
                                require: true,
                                maxlength: 50
                            },
                            email: {
                                require: true,
                                email: true
                            },
                            cityid: {
                                require: true,
                            },
                            phone: {
                                require: true,
                            }
                        },
                    });

                },
            });
        });


        $('body').on('submit', '.formsubmit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('.spinner').html('<i class="fa fa-spinner fa-spin"></i>')
                },
                success: function (data) {
                    PNotify.removeAll();
                    if (data.status == 400) {
                        $('.spinner').html('');
                        new PNotify({
                            title: 'Oh No!',
                            text: data.msg,
                            type: 'error'
                        });
                    }
                    if (data.status == 200) {
                        $('.spinner').html('');
                        $('.add_modal').modal('hide');
                        $('#employee').DataTable().ajax.reload();
                        new PNotify({
                            title: 'Success!',
                            text: data.msg,
                            type: 'success'
                        });
                    }
                },
            });
        });
        /****** delete record******/
        $('body').on('click', '.delete_record', function () {
            var id = $(this).data('id');

            (new PNotify({
                title: "Confirmation Needed",
                text: "Are you sure you wants to delete?",
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                confirm: {
                    confirm: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                },
                addclass: 'stack-modal',
                stack: {
                    'dir1': 'down',
                    'dir2': 'right',
                    'modal': true
                }
            })).get().on('pnotify.confirm', function () {
                $.ajax({
                    url: '{{ url("company/employee/") }}/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                    },
                    success: function (data) {
                        if (data.status == 400) {
                            toastr.error(data.msg, 'Oh No!');
                        }
                        if (data.status == 200) {
                            toastr.success('Record deleted successfully.', 'Success!');
                            $("#employee").DataTable().ajax.reload();
                        }
                    },
                    error: function () {
                        toastr.error('Something went wrong!', 'Oh No!');
                    }
                });
            });
        });
        /** change status**/
        $('body').on('click', '.changestatus', function () {
            var id = $(this).data('id');
            var status = $(this).data('status');
            (new PNotify({
                title: "Confirmation Needed",
                text: "Are you sure you wants to " + status + " this record?",
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                confirm: {
                    confirm: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                },
                addclass: 'stack-modal',
                stack: {
                    'dir1': 'down',
                    'dir2': 'right',
                    'modal': true
                }
            })).get().on('pnotify.confirm', function () {
                $.ajax({
                    url: '{{ route("company.employee.changestatus") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {id: id, status: status},
                    success: function (data) {
                        $("#employee").DataTable().ajax.reload();
                        toastr.success('Status change successfully.', 'Success!');
                    },
                    error: function () {
                        toastr.error('Something went wrong!', 'Oh No!');

                    }
                });
            })

        });
    </script>
    <script>
         $(document).ready(function ()  {          
                $(".importexcel").validate({
                rules: {
                    name: {
                        require: true,
                    }
                    
                },
            });
        
         });
$('body').on('submit', '.importexcel', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('.spinner').html('<i class="fa fa-spinner fa-spin"></i>')
                },
                success: function (data) {
                   
                    if (data.status == 400) {
                        $('.spinner').html('');
                        toastr.error(data.msg)
                    }
                    if (data.status == 200) {
                        $('.spinner').html('');
                        $('.import_excel').modal('hide');
                        $('#employee').DataTable().ajax.reload();
                        toastr.success(data.msg)
                    }
                },
            });
        });
    </script>

@endpush
@endsection

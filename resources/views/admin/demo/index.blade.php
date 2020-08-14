@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Demo')
<div class="container">

    <div class="row">
        <div class="col-12">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Toastr Examples
                    </h3>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success toastrDefaultSuccess">
                        Launch Success Toast
                    </button>
                    <button type="button" class="btn btn-info toastrDefaultInfo">
                        Launch Info Toast
                    </button>
                    <button type="button" class="btn btn-danger toastrDefaultError">
                        Launch Error Toast
                    </button>
                    <button type="button" class="btn btn-warning toastrDefaultWarning">
                        Launch Warning Toast
                    </button>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
                        Launch Large Modal
                    </button>

                    <button type="button" class="btn btn-default confirm">
                        Confirmation
                    </button>
                </div>
                <!-- /.card -->
            </div>
            <div class="card">
                <div class="card-body">
                    <!-- /.card-header -->
                    <table id="example2" class="table table-bordered table-hover" style="background: #fff;">
                        <thead>
                            <tr>
                                <th>Rendering engine</th>
                                <th>Browser</th>
                                <th>Platform(s)</th>
                                <th>Engine version</th>
                                <th>CSS grade</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>Trident</td>
                                <td><span class="badge badge-success">Success</span>
                                </td>
                                <td>Win 95+</td>
                                <td>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-green" role="progressbar" aria-volumenow="47"
                                            aria-volumemin="0" aria-volumemax="100" style="width: 47%">
                                        </div>
                                    </div>
                                    <small>
                                        47% Complete
                                    </small>
                                </td>
                                <td><a class="btn btn-primary btn-sm" href="#">
                                        <i class="fas fa-folder">
                                        </i>
                                        View
                                    </a>
                                    <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-trash">
                                        </i>
                                        Delete
                                    </a></td>
                            </tr>

                            <tr>
                                <td>KHTML</td>
                                <td>Konqureror 3.3</td>
                                <td>KDE 3.3</td>
                                <td>3.3</td>
                                <td>A</td>
                            </tr>
                        </tbody>

                    </table>
                    <!-- /.card-body -->
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</div>
<!--/. container-fluid -->
<div class="modal fade" id="modal-lg">
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
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@push('script')
<script>
$('body').on('click', '.confirm', function() {

    (new PNotify({
        title: 'Confirmation Needed',
        text: "Are you sure?",
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
    })).get().on('pnotify.confirm', function() {
        //ajax
    });

});
$(function() {
    $('.toastrDefaultSuccess').click(function() {
        toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultInfo').click(function() {
        toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultError').click(function() {
        toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultWarning').click(function() {
        toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $("#example2").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>
@endpush
@endsection
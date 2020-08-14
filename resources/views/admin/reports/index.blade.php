@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Reports')

<div class="container">
    <!-- Info boxes -->

    <div class="row">

        <div class="col-12">
            <div class="card card-info card-outline displaybl">
                <div class="card-body" style="padding: 10px 15px;">
                    <div class="col-lg-12">
                        <div class="form-group row " style="margin-bottom: 0px;">
                            <form method="post" style="display: contents;"  action="{{route('admin.report.downloadpdf')}}">
                        {{ csrf_field() }}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><b>Type: </b>
                                    </label>
                                    <select class="form-control type" id="type" name="type">
                                          
                                          <option value="taken">Taken</option>
                                          <option value="not_taken">Not Taken</option>
                                          
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><b>Select Buisness: </b>
                                    </label>
                                    <select class="form-control buisness nottaken" id="buisness" name="buisness">
                                          <option value="">Select Buisness</option>
                                          @if(!empty($businesses))
                                          @foreach($businesses as $business)
                                          <option value="{{ $business->id }}">{{ $business->name }}</option>
                                          @endforeach
                                          @endif
                                    </select>
                                </div>
                            </div>
                        <div class="col-md-5" style="padding-left: 0px;margin-top: 33px;">
                     
                        
                           @if(Auth::user()->role == 'super_admin')
                           <button type="submit" name="submittype" class="btn btn-danger btn-sm" style="padding: 6px 16px;cursor: pointer;background-color: DodgerBlue; border-color: DodgerBlue; " value="pdf" class="btn btn-danger btn-sm"> <i class="fa fa-download" aria-hidden="true"></i> Pdf <span class="spinner"></span>
                           </button>
                           <button type="submit" name="submittype" class="btn btn-danger btn-sm" value="excel" style="padding: 6px 16px;cursor: pointer;background-color: DodgerBlue; border-color: DodgerBlue; "  class="btn btn-success btn-sm" ><i class="fa fa-download" aria-hidden="true"></i>  Excel <span
                              class="spinner"></span>
                            </button>
                            @endif
                        </div>
                        </form>

                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        
            <!-- /.col -->
        </div>

    </div>
    <!-- /.row -->
</div>
<!--/. container-fluid -->
<div class="modal fade add_modal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 15px;">
                <h5 class="modal-title">Large Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body addholidaybody">
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

<script>
var taken = $('.taken').val();
alert(taken);
</script>

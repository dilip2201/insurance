<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\SalaryType;

class SalaryTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.salarytype.index');
    }
    /**
     * Get model for add edit leave type
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodal(Request $request)
    {

        $data = array();
        if (isset($request->id) && $request->id != '') {
            $id = decrypt($request->id);
            $data = SalaryType::where('id',$id)->first();

        }
        return view('company.salarytype.getmodal', compact('data'));
    }
    /**
     * @param Request $request
     * @return mixed
     */
    public function getall(Request $request)
    {

        $salarytype = SalaryType::orderby('id', 'desc');
         $filter_type = $request->filter_type;
        $search = $request->searchvalue;
       // dd($request->minsalary);
        if(!empty($request->filter_type)){
            if($request->filter_type == 'status' && !empty($request->searchvalue)){
                $salarytype = $salarytype->where('status',$request->searchvalue);
            }
            if($request->filter_type == 'code' && !empty($request->code)){
                $salarytype = $salarytype->where('code',$request->code);
            }
            if($request->filter_type == 'title' && !empty($request->title)){
                $salarytype = $salarytype->where('title',$request->title);
            }
        }
       
        $salarytype = $salarytype->get();
        return DataTables::of($salarytype)
            ->addColumn('action', function ($q) {
                $id = encrypt($q->id);
                return '<a title="Edit"  data-id="'.$id.'"   data-toggle="modal" data-target=".add_modal" class="btn btn-info btn-sm openaddmodal" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i> Edit</a>
                          <a class="btn btn-danger btn-sm delete_record" data-id="' . $q->id . '" href="javascript:void(0)"> <i class="fas fa-trash"></i> Delete</a>';
            })
            ->addColumn('title', function ($q) {
                return $q->title;
            })
            ->addColumn('code', function ($q) {
                return $q->code;
            })
            ->addColumn('rate', function ($q) {
                return $q->rate;
            })
            ->addColumn('created_at', function ($q) {
                return date('d M Y', strtotime($q->created_at));
            })
            ->addColumn('status', function ($q) {
                $id = encrypt($q->id);
                if ($q->status == 'active') {
                    return ' <a  class="badge badgesize badge-success right changestatus" data-status="inactive" data-id="' . $id . '" href="javascript:void(0)">' . ucwords($q->status) . '</a>';
                }
                if ($q->status == 'inactive') {
                    return '<a class="badge badgesize badge-danger right changestatus"  data-status="active"  data-id="' . $id . '" href="javascript:void(0)">' . ucwords($q->status) . '</a>';
                }
            })
            ->addIndexColumn()
            ->rawColumns(['status', 'action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'rate' => 'required',
        ];
        if (isset($request->id)) {
            $id = decrypt($request->id);
            $rules['title'] = 'required|unique:salary_types,title,' . $id;
            $rules['code'] = 'required|unique:salary_types,code,' . $id;
            $msg = 'Salary Type updated successfully';
        } else {
            $rules['title'] = 'required|unique:salary_types,title';
            $rules['code'] = 'required|unique:salary_types,code';
            $msg = 'Salary Type added successfully';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {

            try {

                if (isset($request->id)) {
                    $id = decrypt($request->id);
                    $salarytype = SalaryType::find($id);
                }else{
                    $salarytype = new SalaryType;
                }

                $salarytype->userid = Auth::user()->id;
                $salarytype->title = $request->title;
                $salarytype->code = $request->code;
                $salarytype->rate = $request->rate;
                $salarytype->save();
                $arr = array("status" => 200, "msg" => $msg);
            } catch (\Illuminate\Database\QueryException $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            }
        }

        return \Response::json($arr);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = SalaryType::find($id);
            if ($data) {
                $data->delete();
                $arr = array("status" => 200, "msg" => 'Record delete successfully.');
            } else {
                $arr = array("status" => 400, "msg" => 'Record not found. please try again!');
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            $msg = 'You can not delete this as related data are there in system.';
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            }
            $arr = array("status" => 400, "msg" => $msg, "result" => array());
        } catch (Exception $ex) {
            $msg = 'You can not delete this as related data are there in system.';
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            }
            $arr = array("status" => 400, "msg" => $msg, "result" => array());
        }
        return \Response::json($arr);
    }
    /**
     * Change status of employee active or inactive
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response send response in json
     */
    public function changestatus(Request $request)
    {

        try {
            $id = decrypt($request->id);
            $data = SalaryType::find($id);
            if ($data) {
                $data->update(['status' => $request->status]);
                $arr = array("status" => 200, "msg" => 'Salary Type status change successfully.');
            } else {
                $arr = array("status" => 400, "msg" => 'Salary Type not found. please try again!');
            }

        } catch (\Illuminate\Database\QueryException $ex) {

            $msg = $ex->getMessage();
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            }

            $arr = array("status" => 400, "msg" => $msg, "result" => array());
        } catch (Exception $ex) {

            $msg = $ex->getMessage();
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            }
            $arr = array("status" => 400, "msg" => $msg, "result" => array());
        }
        return \Response::json($arr);
    }
}

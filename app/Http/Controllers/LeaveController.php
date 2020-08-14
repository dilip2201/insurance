<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\LeaveApply;

class LeaveController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.leave.index');
       
    }
/**
     * @param Request $request
     * @return mixed
     */
    public function getall(Request $request)
    {
        $empids = User::where('parentid', Auth::user()->id)->pluck('id');
        $LeaveApply = LeaveApply::whereIn('userid',$empids)->orderby('id', 'desc');
        
        $filter_type = $request->filter_type;
        $search = $request->searchvalue;
       // dd($request->minsalary);
        if(!empty($request->filter_type)){
            if($request->filter_type == 'status' && !empty($request->searchvalue)){
                $LeaveApply = $LeaveApply->where('status',$request->searchvalue);
            }
            if($request->filter_type == 'employee' && !empty($request->searchvalue)){
                $LeaveApply = $LeaveApply->where('userid',$request->searchvalue);
            }            
            if($request->filter_type == 'date' && !empty($request->fromdate)){
                $fromdate = $request->fromdate;
                $todate =  $request->todate; 
                $LeaveApply = $LeaveApply->where('dateFrom', '>=', $fromdate)
                  ->where('dateTo', '<=', $todate);               
            }
        }
        $LeaveApply = $LeaveApply->get();
        return DataTables::of($LeaveApply)
            ->addColumn('action', function ($q) {
                $id = encrypt($q->id);
                if ($q->status == 'pending') {
                    return ' <a  class="badge badgesize badge-success right changestatus" data-status="approve" data-id="' . $id . '" href="javascript:void(0)">Approve</a> <a  class="badge badgesize badge-danger right changestatus" data-status="disapprove" data-id="' . $id . '" href="javascript:void(0)">Disapprove</a>';
                }
                if ($q->status == 'approve') {
                    return '<a class="badge badgesize badge-success right "  disable href="javascript:void(0)">' . ucwords($q->status) . '</a>';
                }
                if ($q->status == 'disapprove') {
                    return '<a class="badge badgesize badge-danger right "  disable href="javascript:void(0)">' . ucwords($q->status) . '</a>';
                }
                
            })
            ->addColumn('leavetype', function ($q) {
                return $q->leavetype->leave_type;
            })
            ->addColumn('empname', function ($q) {
                return $q->user->name.' '.$q->user->lastname;
            })
            ->addColumn('reason', function ($q) {
                return $q->reason;
            })
            ->addColumn('dateFrom', function ($q) {
                return date('d M Y', strtotime($q->dateFrom));
            })
            ->addColumn('dateTo', function ($q) {
                return date('d M Y', strtotime($q->dateTo));
            })
            ->addColumn('days', function ($q) {
                return $q->days;
            })
            ->addColumn('created_at', function ($q) {
                return date('d M Y', strtotime($q->created_at));
            })
            ->addColumn('status', function ($q) {
                $id = encrypt($q->id);
                if ($q->status == 'pending') {
                    return ' <a  class="badge badgesize badge-success right changestatus" data-status="approve" data-id="' . $id . '" href="javascript:void(0)">Approve</a> <a  class="badge badgesize badge-danger right changestatus" data-status="disapprove" data-id="' . $id . '" href="javascript:void(0)">Disapprove</a>';
                }
                if ($q->status == 'approve') {
                    return '<span class="badge badgesize badge-success right "  disable href="javascript:void(0)">' . ucwords($q->status) . 'ed</span>';
                }
                if ($q->status == 'disapprove') {
                    return '<span class="badge badgesize badge-danger right "  disable href="javascript:void(0)">' . ucwords($q->status) . 'ed</span>';
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
        //
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
        //
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
            $leavetype = LeaveApply::find($id);
            if ($leavetype) {
                $leavetype->update(['status' => $request->status]);
                $arr = array("status" => 200, "msg" => 'Leave '.$request->status.' successfully.');
            } else {
                $arr = array("status" => 400, "msg" => 'Leave not found. please try again!');
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
    public function getfilter(Request $request)
    {

        $employee = array();
        $type = $request->type;

        $employees = User::where(['parentid'=>Auth::user()->id],['status'=>'active'])->get();         
        return view('company.leave.getfilter', compact('type','employees'));
    }
}

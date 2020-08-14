<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;   
use App\PremiumReport;
use App\PremiumLog;
use Auth;
use Carbon\Carbon;
use App\Client;
use App\Group;
use App\Company;

class PremiumReportControler extends Controller
{
/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $start = Carbon::now()->endOfMonth()->subMonth()->toDateString();
        $end = Carbon::now()->startofMonth()->endOfMonth()->toDateString();
        $clients = client::get();
        $groups = Group::get();
        $companies = Company::get();
        return view('admin.premiumreport.index',compact('start','end','clients','groups','companies'));
    }
        /**
     * Get all the users
     * @param Request $request
     * @return mixed
     */
    public function getall(Request $request)
    {
        $chkstartdate = $request->start_date;
        $chkenddate = $request->end_date;

        $premiumreport = PremiumReport::with('client','work','company')->orderby('id', 'desc');
       
        if (isset($request->start_date) && !empty($request->start_date) && isset($request->end_date) && !empty($request->end_date)) {
            $premiumreport = $premiumreport->whereBetween('due_date', [$chkstartdate, $chkenddate]);
        }
        if (isset($request->group) && !empty($request->group)) {
            $groupid = $request->group;
            $premiumreport = $premiumreport->whereHas('client.group', function($q) use($groupid){
                $q->where('id', $groupid);
        });
        }
        if (isset($request->work) && !empty($request->work)) {
            $premiumreport = $premiumreport->whereHas('work', function($q) use($request){
                $q->where('work', $request->work);
            });
        }
        if (isset($request->client) && !empty($request->client)) {
            $premiumreport = $premiumreport->where('client_id',$request->client);
        }
        if (isset($request->company) && !empty($request->company)) {
            $premiumreport = $premiumreport->where('company_id',$request->company);
        }

        $premiumreport = $premiumreport->get();

        
        return DataTables::of($premiumreport)
            ->addColumn('action', function ($q) {
                $id = encrypt($q->id);
                $return = '<a title="Due date"  data-id="'.$q->id.'"   data-toggle="modal" data-target=".add_log" class="btn btn-info btn-sm openaddmodallog" href="javascript:void(0)"><i class="fa fa-plus"></i></a>  <a title="Logs"  data-id="'.$q->id.'"   data-toggle="modal" data-target=".history_log" class="btn btn-danger btn-sm history_log_show" href="javascript:void(0)"><i class="fa fa-history" aria-hidden="true"></i> </a>';
                
                return $return;
            })
            ->addColumn('client_id', function ($q) {
                return $q->client->name_salutation.' '.$q->client->first_name.' '.$q->client->last_name;
            })
            ->addColumn('work_id', function ($q) {
                return ucwords(str_replace('_', ' ', $q->work->work));
            })
            ->addColumn('company_id', function ($q) {
                return $q->company->name;
            })
            ->addColumn('status', function ($q) {
                $return = '';
                   $return = '<select class="form-control changestatus">
                     <option value="Pending" data-status="Pending" data-id ="'.$q->id.'"';
                     if($q->status == 'Pending'): $return .= 'selected'; endif; $return .='>Pending</option>
                        <option value="Completed" data-status="Completed" data-id ="'.$q->id.'"';
                     if($q->status == 'Completed'): $return .= 'selected'; endif; $return .='>Completed</option>
                        <option value="Hold" data-status="Hold" data-id ="'.$q->id.'"';
                     if($q->status == 'Hold'): $return .= 'selected'; endif; $return .='>Hold</option>
                        <option value="Prospect" data-status="Prospect" data-id ="'.$q->id.'"';
                     if($q->status == 'Prospect'): $return .= 'selected'; endif; $return .='>Prospect</option></select>';
                 
                 return $return;
             })
            ->addIndexColumn()
            ->rawColumns(['action','status'])->make(true);
    }
    /**
     * status change
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function changestatus(Request $request) {
        try {

            $premiumreport = PremiumReport::find($request->id)->update(['status'=>$request->status]);
            $firstpremiumreport = PremiumReport::find($request->id)->first();    

            $premiumlog = new PremiumLog;
            $premiumlog->premium_report_id = $request->id;
            $premiumlog->user_id = Auth::user()->id;
            $premiumlog->next_followup_date =  $firstpremiumreport->due_date;
            $premiumlog->status = $request->status;
            $premiumlog->comment = "Your status change successfully as ".$request->status.".";
            $premiumlog->save();
            $arr = array("status" => 200, "msg" => 'success');
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

        /**
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storelog(Request $request)
    {

        $rules = [
            'comment' => 'required',
            'date' =>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {
                $premiumlog = new PremiumLog;
                $premiumlog->premium_report_id = $request->premium_report_id;
                $premiumlog->user_id = Auth::user()->id;
                $premiumlog->status = $request->status;
                if(!empty($request->status) && isset($request->status)){
                    $premiumlog->next_followup_date = $request->date;    
                }
                $premiumlog->next_followup_date = $request->date;
                $premiumlog->comment = $request->comment;
                $premiumlog->save();

                if(!empty($request->status) && isset($request->status)){
                    PremiumReport::where('id',$request->premium_report_id)->update(['status' => $request->status,'due_date'=>$request->date]);
                 }else{
                    PremiumReport::where('id',$request->premium_report_id)->update(['status' => $request->status]);
                 }

                $arr = array("status" => 200, "msg" => "Follow Up Log Added Successfully");
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
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodallog(Request $request)
    {

        $premium_report_id = $request->id;
        $user_id = Auth::user()->id;
        $status = PremiumReport::where('id',$premium_report_id)->first();
        return view('admin.premiumreport.duedate',compact('premium_report_id','user_id','status'));
    }
    /**
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodalhistory(Request $request)
    {
        $histories = PremiumLog::where('user_id',auth()->user()->id)->where('premium_report_id',$request->id)->orderBy('created_at','desc')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
        return view('admin.premiumreport.historylog',compact('histories'));
    }
}

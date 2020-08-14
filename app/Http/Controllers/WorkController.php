<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DataTables;
use Validator;
use App\Work;
use App\Client;
use App\Company;
use App\Group;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\PremiumReport;
use Carbon\Carbon;
class WorkController extends Controller
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
       // getMonthListFromDate('2019-01-29','2020-01-31');
        $clients = client::get();
        $groups = Group::get();
        return view('admin.works.index',compact('clients','groups'));
    }

    /**
     * Get all the users
     * @param Request $request
     * @return mixed
     */
    public function getall(Request $request)
    {
        $getstartdate = $request->startdate;
        $startdate = explode("GMT", $getstartdate);
        $chkstartdate = date('Y-m-d', strtotime($startdate[0]));


        $getenddate = $request->enddate;
        $enddate = explode("GMT", $getenddate);
        $chkenddate = date('Y-m-d', strtotime($enddate[0]));

        $works = Work::orderby('id', 'desc');
        if (isset($request->group) && !empty($request->group)) {
            $groupid = $request->group;
            $works = $works->whereHas('client.group', function($q) use($groupid){
            $q->where('id', $groupid);
        });
        }
        if (isset($request->work) && !empty($request->work)) {
            $works = $works->where('work',$request->work);
        }
        if (isset($request->client) && !empty($request->client)) {
            $works = $works->where('client_id',$request->client);
        }

        if (isset($request->startdate) && !empty($request->startdate) && isset($request->enddate) && !empty($request->enddate)) {
            $works = $works->where(function ($q) use ($chkstartdate, $chkenddate) {
                $q->where([['start_date','<=',$chkstartdate],['end_date','>=',$chkenddate]])
                ->orwhereBetween('start_date',array($chkstartdate,$chkenddate))
                ->orWhereBetween('end_date',array($chkstartdate,$chkenddate));
            });
        }
        if (isset($request->status) && !empty($request->status)) {
            $works = $works->where('status',$request->status);
        }



        
        $works = $works->get();

        return DataTables::of($works)
            ->addColumn('action', function ($q) {
                $id = encrypt($q->id);
                $return = '<a title="Edit"  data-id="'.$id.'"   data-toggle="modal" data-target=".add_modal" class="btn btn-info btn-sm openaddmodal" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i></a>';
                return $return;
            })            
            ->addColumn('client_id', function ($q) {
                return $q->client->name_salutation.' '.$q->client->first_name.' '.$q->client->last_name;
            })
            ->addColumn('company_id', function ($q) {
                return $q->company->name;
            })
            ->addColumn('work', function ($q) {
                return ucwords(str_replace('_', ' ', $q->work));
            })
            ->addColumn('start_date', function ($q) {
                return $q->start_date;
            })
            ->addColumn('end_date', function ($q) {
                return $q->end_date;
            })
            ->addColumn('period', function ($q) {
                return ucwords(str_replace('_', ' ', $q->period));
            })
            ->addColumn('status', function ($q) {
                $id = encrypt($q->id);
                if ($q->status == 'open') {
                    return '<div class="switchToggle"><input type="checkbox" id="switch'.$q->id.'" name="status" class="group_headis changestatus" data-status = "closed" data-id="'.$q->id.'">
                    <label for="switch'.$q->id.'">Toggle</label></div>';
                }
                if ($q->status == 'closed') {
                    return '<div class="switchToggle"><input type="checkbox" id="switch'.$q->id.'" name="status" 
                    data-status = "open" data-id="'.$q->id.'" class="group_headis changestatus" checked>
                    <label for="switch'.$q->id.'">Toggle</label></div>';
                }
            })
            ->addIndexColumn()
            ->rawColumns(['image','status', 'action'])->make(true);
    }
    
    /**
     * download pdf.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadpdf(Request $request)
    {
        /*$getstartdate = $request->startdate;
        $startdate = explode("GMT", $getstartdate);
        $chkstartdate = date('Y-m-d', strtotime($startdate[0]));
        $request->start_date = $chkstartdate;


        $getenddate = $request->enddate;
        $enddate = explode("GMT", $getenddate);
        $chkenddate = date('Y-m-d', strtotime($enddate[0]));
        $request->end_date = $chkenddate;*/

        $nameclient = $namegroup = $namework = $startdate = $enddate = '';
        if(isset($request->client) && !empty($request->client)) {
            $client = \DB::table('clients')->where('id',$request->client)->first();
            if(!empty($client)){
               $nameclient = $client->name_salutation.' '.$client->first_name.' '.$client->last_name.'-';   
            }
        }
        if(isset($request->work) && !empty($request->work)) {
            $namework = str_replace('_', ' ', $request->work.'-');
        }
        if(isset($request->group) && !empty($request->group)) {
            $groupid = $request->group;
            $group = \DB::table('groups')->where('id',$groupid)->first();
            if(!empty($group)){
                $namegroup = $group->name.'-';    
            }
            
        }
        if (isset($request->start_date) && !empty($request->start_date)) {
            $startdate = $request->start_date.'-';
        }
        if (isset($request->end_date) && !empty($request->end_date)) {
            $enddate = $request->end_date.'-';
        }
       

        $works = Work::orderby('id', 'desc');
        if (isset($request->group) && !empty($request->group)) {
            $groupid = $request->group;
            $works = $works->whereHas('client.group', function($q) use($groupid){
                                        $q->where('id', $groupid);
                    });
        }
        if (isset($request->work) && !empty($request->work)) {
            $works = $works->where('work',$request->work);
        }
        if (isset($request->client) && !empty($request->client)) {
            $works = $works->where('client_id',$request->client);
        }

        if (isset($request->start_date) && !empty($request->start_date) && isset($request->end_date) && !empty($request->end_date)) {
            $works = $works->whereBetween('start_date',[$request->start_date,$request->end_date]);
        }
        if (isset($request->status) && !empty($request->status)) {
            $works = $works->where('status',$request->status);
        }

        
        $works = $works->get(); 
        if($request->submittype == 'pdf') {
            $pdf = PDF::loadview('admin.works.workpdf',compact('works','nameclient','namegroup','namework'));
            return $pdf->download(''. $nameclient .''. $namegroup .''. $namework .''.$startdate.''.$enddate.'works.pdf');
        }else if ($request->submittype == 'excel'){

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Client Name');
            $sheet->getColumnDimension('A')->setAutoSize(true);

            $sheet->setCellValue('B1', 'Work');
            $sheet->getColumnDimension('B')->setAutoSize(true);

            $sheet->setCellValue('C1', 'Company');
            $sheet->getColumnDimension('C')->setAutoSize(true);

            $sheet->setCellValue('D1', 'Document Number');
            $sheet->getColumnDimension('D')->setAutoSize(true);

            $sheet->setCellValue('E1', 'Amount');
            $sheet->getColumnDimension('E')->setAutoSize(true);

            $sheet->setCellValue('F1', 'Start Date');
            $sheet->getColumnDimension('F')->setAutoSize(true);

            $sheet->setCellValue('G1', 'End Date');
            $sheet->getColumnDimension('G')->setAutoSize(true);

            $sheet->setCellValue('H1', 'Period');
            $sheet->getColumnDimension('H')->setAutoSize(true);

            $sheet->setCellValue('I1', 'Status');
            $sheet->getColumnDimension('I')->setAutoSize(true);


            $sheet->freezePaneByColumnAndRow(1, 2);
            if (!empty($works)) {
                $i = 2;
                foreach ($works as $work) {
                    $sheet->setCellValue('A' . $i, $work->client->name_salutation.' '.$work->client->first_name.' '.$work->client->last_name);
                    $sheet->setCellValue('B' . $i, $work->work);
                    $sheet->setCellValue('C' . $i,  $work->company->name);
                    $sheet->setCellValue('D' . $i,  $work->unique_number);
                    $sheet->setCellValue('E' . $i,  $work->amount);
                    $sheet->setCellValue('F' . $i,  $work->start_date);
                    $sheet->setCellValue('G' . $i,  $work->end_date);
                    $sheet->setCellValue('H' . $i,  ucwords(str_replace('_', ' ', $work->period)));
                    $sheet->setCellValue('I' . $i, $work->status);
                    $i++;
                }
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. $nameclient .''. $namegroup .''. $namework .''.$startdate.''.$enddate.'works.xlsx"');
            $writer->save("php://output");

        }
    }

    public function getmodal(Request $request)
    {
        $clients = client::get();
        $companies = Company::get();

        $work = array();
        if (isset($request->id) && $request->id != '') {
            $id = decrypt($request->id);
            $work = Work::where('id',$id)->first();

        }
        return view('admin.works.getmodal',compact('clients','companies','work'));
    }

    public function changestatus(Request $request)
    {
        try {

         
            $id = $request->id;
            $holiday = Work::find($id);
            if ($holiday) {
                
                $records = \DB::table('premium_reports')->where('due_date' , '>=' , Carbon::now()->toDateTimeString())->where('work_id',$id)->delete();
                
                if ($request->status == 'open') {
                    $period = $holiday->period;
                    if($period == 'one_time'){

                        $premiumdateone = Carbon::parse($holiday->start_date);
                        $todayone = Carbon::now();
                        if($premiumdateone->gte($todayone)){
                            $pr = new PremiumReport;
                            $pr->client_id = $holiday->client_id;
                            $pr->due_date = $holiday->start_date;
                            $pr->work_id = $holiday->id;
                            $pr->company_id = $holiday->company_id;
                            $pr->amount = $holiday->amount;
                            $pr->status = 'Pending';
                            $pr->save();
                        }
                    }
                    $premiums = array();
                    if($period == 'monthly'){
                        $premiums = getMonthListFromDate($holiday->start_date,$holiday->end_date,'1 month');
                    }
                    if($period == 'quarterly'){
                        $premiums = getMonthListFromDate($holiday->start_date,$holiday->end_date,'3 month');
                    }
                    if($period == 'half_yearly'){
                        $premiums = getMonthListFromDate($holiday->start_date,$holiday->end_date,'6 month');
                    }
                    if($period == 'yearly'){
                        $premiums = getMonthListFromDate($holiday->start_date,$holiday->end_date,'12 month');
                    }

                    if(!empty($premiums)){
                        foreach ($premiums as $premium) {
                            $premiumdate = Carbon::parse($premium);
                            $today = Carbon::now();
                            if($premiumdate->gt($today)){
                                $pr = new PremiumReport;
                                
                                $pr->client_id = $holiday->client_id;
                                $pr->due_date = $premium;
                                $pr->work_id = $holiday->id;
                                $pr->company_id = $holiday->company_id;
                                $pr->amount = $holiday->amount;
                                $pr->status = 'Pending';
                                $pr->save();
                            }
                            
                        }
                    }
                }


                $holiday->update(['status' => $request->status]);
                $arr = array("status" => 200, "msg" => 'Holiday status change successfully.');
            } else {
                $arr = array("status" => 400, "msg" => 'Holiday not found. please try again!');
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

    public function getcompanymodal(Request $request)
    {
        return view('admin.works.getcompanymodal',);
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

        ];
        if (isset($request->workid)) {
            $workid = decrypt($request->workid);
            $rules['doc_number'] = 'required|unique:works,unique_number,'.$workid;
        }else{
            $rules['doc_number'] = 'required|unique:works,unique_number';
          
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {
               
                if (isset($request->workid)) {
                    $id = decrypt($request->workid);
                    $work = Work::find($id);
                    $msg = "Work updated successfully.";
                }else{
                    $work = new Work;
                    $msg = "Work added successfully.";
                }
                if($request->status == 'on'){
                    $status = 'closed';
                }else{
                    $status = 'open';
                }
                $work->client_id = $request->client;
                $work->work = $request->work;
                $work->company_id = $request->name;
                $work->unique_number = $request->doc_number;
                $work->amount = $request->amount;
                $work->start_date = $request->start_date;
                $work->end_date = $request->end_date;
                $work->period = $request->period;
                $work->description = $request->description;
                $work->status = $status;
                $work->save();

                if (isset($request->workid) && !empty($request->workid)) {
                    $records = \DB::table('premium_reports')->where('due_date' , '>=' , Carbon::now()->toDateTimeString())->where('work_id',decrypt($request->workid))->delete();
                    
                }

                if ($work->status == 'open') {
                    $period = $request->period;
                    if($period == 'one_time'){

                        $premiumdateone = Carbon::parse($request->start_date);
                        $todayone = Carbon::now();
                        if($premiumdateone->gte($todayone)){
                            $pr = new PremiumReport;
                            $pr->client_id = $request->client;
                            $pr->due_date = $request->start_date;
                            $pr->work_id = $work->id;
                            $pr->company_id = $request->name;
                            $pr->amount = $request->amount;
                            $pr->status = 'Pending';
                            $pr->save();
                        }
                    }
                    $premiums = array();
                    if($period == 'monthly'){
                        $premiums = getMonthListFromDate($request->start_date,$request->end_date,'1 month');
                    }
                    if($period == 'quarterly'){
                        $premiums = getMonthListFromDate($request->start_date,$request->end_date,'3 month');
                    }
                    if($period == 'half_yearly'){
                        $premiums = getMonthListFromDate($request->start_date,$request->end_date,'6 month');
                    }
                    if($period == 'yearly'){
                        $premiums = getMonthListFromDate($request->start_date,$request->end_date,'12 month');
                    }

                    if(!empty($premiums)){
                        foreach ($premiums as $premium) {
                            $premiumdate = Carbon::parse($premium);
                            $today = Carbon::now();
                            if($premiumdate->gt($today)){
                                $pr = new PremiumReport;
                                $pr->client_id = $request->client;
                                $pr->due_date = $premium;
                                $pr->work_id = $work->id;
                                $pr->company_id = $request->name;
                                $pr->amount = $request->amount;
                                $pr->status = 'Pending';
                                $pr->save();
                            }
                            
                        }
                    }
                }
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

    public function companyload(Request $request){
        $companies = Company::get();
        $company_id = 0;
        $company_id = $request->selectedcompany;
        
        return view('admin.works.companyload',compact('companies','company_id'));
    }
    public function storecompany(Request $request)
    {
        $rules = [
            'name' => 'required|unique:companies,name'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {
                $company = new Company;
                $company->name = $request->name;
                $company->save();
                $arr = array("status" => 200, "msg" => "Company Add successfully");
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

}

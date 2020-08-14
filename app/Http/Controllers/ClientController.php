<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Client;
use App\Group;
use Validator;
use App\Business;
use Carbon\Carbon;
use DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PDF;
class ClientController extends Controller
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
     * Load client view
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::get();
        $businesses = Business::get();
        return view('admin.clients.index',compact('groups','businesses'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getall(Request $request)
    {
        $users = Client::with('group')->orderby('id', 'desc');
        if (isset($request->status) && !empty($request->status)) {
            $users = $users->where('status',$request->status);
        }
        if (isset($request->group) && !empty($request->group)) {
            $users = $users->where('group_id',$request->group);
        }

        if (!empty($request->buisness) && !empty($request->type)) {
            if($request->type == "taken"){
                $users = $users->whereHas('business' , function($query) use ($request){
                    $query->where('business_id', '=',$request->buisness);
                });
            }else if($request->type == "not_taken"){
                 $users = $users->whereDoesntHave('business' , function($query) use ($request){
                    $query->where('business_id', '=',$request->buisness);
                });
            }
        }
        

        $users = $users->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR,clients.date_of_birth,CURDATE())'),array($request->min,$request->max));
        
        
        $users = $users->get();
        return DataTables::of($users)
            ->addColumn('action', function ($q) {
                $id = encrypt($q->id);
                $return = '<a class="btn btn-primary btn-sm openclientview" data-toggle="modal" data-client_id="'.$id.'" data-typeid="" data-target=".view_detail" href="#"><i class="fas fa-folder"></i> </a> | <a title="Edit" data-client_id="'.$id.'" class="btn btn-info btn-sm addclientclick" href="#"><i class="fas fa-pencil-alt"></i> </a>';
                return $return;
            })

            ->addColumn('group', function ($q) {
                return $q->group->name;
            })
  
            ->addColumn('name', function ($q) {
                $head = '';
                if($q->group_head == 'yes'){
                    $head = '(Head)';
                }
                return $q->name_salutation.' '.$q->first_name.' '.$q->last_name.$head;
            })
            ->addColumn('mobile_number', function ($q) {
                return $q->mobile_number;
            })
            ->addColumn('email', function ($q) {
                return $q->email;
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
            ->addColumn('id', function ($q) {
                return $q->client_number ?? '';
            })
            ->addIndexColumn()
            ->rawColumns(['status', 'action'])->make(true);
    }

    public function clientloadform(Request $request){
        $groups = Group::get();
        $businesses = Business::get();
        $client = array();
        if(isset($request->clientid) && !empty($request->clientid)) {
            $id = decrypt($request->clientid);
            $client = Client::with('business')->where('id',$id)->first();
        }
        return view('admin.clients.loadform',compact('groups','businesses','client'));
    }

    public function groupload(Request $request){
        $groups = Group::get();
        $groupid = 0;
        $groupid = $request->selectedgroup;
        return view('admin.clients.groupload',compact('groups','groupid'));
    }
    public function selectgroup(Request $request){
        $client = \DB::table('clients')->where('group_id',$request->groupname)->where('group_head','yes')->first();
        if(!empty($client)){
            $return = array('group_head'=>'yes','data'=>$client);
        }else{
            $return = array('group_head'=>'no');
        }
        return \Response::json($return);
    }


    
    /**
     * Add new group for client
     *
     * @return \Illuminate\Http\Response
     */
    public function groupstore(Request $request){
       
            
        $rules = [
            'name' => 'required|unique:groups,name',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {
                $group = new Group;
                $group->name = $request->name;
                $group->save();

                $groupupdate = Group::find($group->id);
                $groupnumber =  'G'.str_pad($group->id, 3, "0", STR_PAD_LEFT);
                $groupupdate->code = $groupnumber;
                $groupupdate->save();


                $arr = array("status" => 200, "msg" => "Group added successfully.", "result" => array());
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
        }
        return \Response::json($arr);
    }

    public function changestatus(Request $request)
    {

        try {
            $id = decrypt($request->id);
            $holiday = Client::find($id);
            if ($holiday) {
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


    public function viewdetail(Request $request){
        $id = decrypt($request->client_id);
        $clients = Client::whereId($id)->first();
        return view('admin.clients.show',compact('clients'));
    }
   

    /**
     * Store data of client and update
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
    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'business_done'=>'required',
            'group' => 'required'
        ];
       
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {
                
                
                $msg = "Client added successfully.";
                if(isset($request->client_id) && !empty($request->client_id)){
                    $client = Client::find($request->client_id);
                }else{
                    $client = new Client;    
                }
                
                $client->group_id = $request->group;
                $client->name_salutation = $request->name_salutation;
                $client->first_name = $request->first_name;
                $client->last_name = $request->last_name;
                $client->relation = $request->relation;
                if(isset($request->group_head) && !empty($request->group_head)){
                    \DB::table('clients')->where('group_id',$request->group)->update(['group_head'=>'no']);
                    $client->group_head = 'yes';
                }else{
                    $client->group_head = 'no';
                }
                $client->date_of_birth = $request->date_of_birth;
                $client->date_of_anniversary = $request->date_of_anniversary;
                $client->mobile_number = $request->mobile_number;
                $client->whatsapp_number = $request->whatsapp_number;
                $client->middle_name = $request->middle_name;
                $client->email = $request->email;
                $client->address_1 = $request->address_1;
                $client->address_2 = $request->address_2;
                $client->area = $request->area;
                $client->city = $request->city;
                $client->pin_code = $request->pin_code;
                $client->client_category = $request->client_category;
                $client->save();

                $clientupdate = Client::find($client->id);
                $clientnumber =  'C'.str_pad($client->id, 4, "0", STR_PAD_LEFT);
                $clientupdate->client_number = $clientnumber;
                $clientupdate->save();

                $client->business()->sync($request->business_done);

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadpdf(Request $request)
    {

        $users = Client::with('group')->orderby('id', 'desc');
        if (isset($request->status) && !empty($request->status)) {
            $users = $users->where('status',$request->status);
        }
        if (isset($request->group) && !empty($request->group)) {
            $users = $users->where('group_id',$request->group);
        }

        if (!empty($request->buisness) && !empty($request->type)) {
            if($request->type == "taken"){
                $users = $users->whereHas('business' , function($query) use ($request){
                    $query->where('business_id', '=',$request->buisness);
                });
            }else if($request->type == "not_taken"){
                 $users = $users->whereDoesntHave('business' , function($query) use ($request){
                    $query->where('business_id', '=',$request->buisness);
                });
            }
        }
        
        $users = $users->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR,clients.date_of_birth,CURDATE())'),array($request->min,$request->max));
        
        $users = $users->get();
        
        if($request->submittype == 'pdf') {
           $name = "";
           $type = "";
            if (!empty($request->buisness) && !empty($request->type)) {
                $business = Business::where('id',$request->buisness)->first();
                $name = ucwords(str_replace('_', ' ', $business->name));

                $type = $request->type;
            }

           $pdf = PDF::loadview('admin.clients.clientspdf',compact('users','name','type'));
           return $pdf->download('clients.pdf');
        }else if ($request->submittype == 'excel'){

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Sr. No.');
            $sheet->getColumnDimension('A')->setAutoSize(true);

            $sheet->setCellValue('B1', 'Client Name');
            $sheet->getColumnDimension('B')->setAutoSize(true);

            $sheet->setCellValue('C1', 'Group');
            $sheet->getColumnDimension('C')->setAutoSize(true);

            $sheet->setCellValue('D1', 'Mobile No.');
            $sheet->getColumnDimension('D')->setAutoSize(true);

            $sheet->setCellValue('E1', 'Email');
            $sheet->getColumnDimension('E')->setAutoSize(true);

            $sheet->setCellValue('F1', 'Status');
            $sheet->getColumnDimension('F')->setAutoSize(true);


            $sheet->freezePaneByColumnAndRow(1, 2);
            if (!empty($users)) {
                $i = 2;
                foreach ($users as $user) {

                     $sheet->setCellValue('A' . $i, $user->client_number );
                    $sheet->setCellValue('B' . $i, $user->name_salutation.' '.$user->first_name.' '.$user->last_name);
                    $sheet->setCellValue('C' . $i, $user->group->name);
                    $sheet->setCellValue('D' . $i,  $user->mobile_number );
                    $sheet->setCellValue('E' . $i, $user->email );
        
                    $sheet->setCellValue('F' . $i,  ucwords($user->status));
                   
                    $i++;
                }
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="clients.xlsx"');
            $writer->save("php://output");

        }
    
}
}


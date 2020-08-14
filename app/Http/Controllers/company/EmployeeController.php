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
use App\EmployeeDetail;
use App\SalaryType;

class EmployeeController extends Controller
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
        return view('company.employee.index');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getall(Request $request)
    {

        $employee = User::where('parentid',Auth::user()->id)
            ->whereRole('employee')->orderby('id', 'desc');
       /* if (isset($request->status) && !empty($request->status)) {
            $employee = $employee->where('status', $request->status);
        }*/
        $filter_type = $request->filter_type;
        $search = $request->searchvalue;
       // dd($request->minsalary);
        if(!empty($request->filter_type)){
            if($request->filter_type == 'status' && !empty($request->searchvalue)){
                $employee = $employee->where('status',$request->searchvalue);
            }
            if($request->filter_type == 'department' && !empty($request->searchvalue)){
                $searchvalue = $request->searchvalue;
                $employee = $employee->whereHas('employee_detail', function ($query) use ($searchvalue){
                    $query->where('department', $searchvalue);
                });
            }
            if($request->filter_type == 'qualification' && !empty($request->searchvalue)){
                $searchvalue = $request->searchvalue;
                $employee = $employee->whereHas('employee_detail', function ($query) use ($searchvalue){
                    $query->where('qualification', $searchvalue);
                });
            }
            if($request->filter_type == 'date_of_joining' && !empty($request->date_of_joining)){
                $searchvalue = $request->date_of_joining;
                $employee = $employee->whereHas('employee_detail', function ($query) use ($searchvalue){
                    $query->where('date_of_joining', $searchvalue);
                });
            }
            if($request->filter_type == 'salary' && !empty($request->minsalary)){
                $minsalary = str_replace("$", "", $request->minsalary);
                $maxsalary = str_replace("$", "", $request->maxsalary);
                $employee = $employee->whereHas('employee_detail', function ($query) use ($minsalary, $maxsalary){
                    $query->whereBetween('salary', [$minsalary, $maxsalary]);
                });
            }


        }
        $employee = $employee->get();
        return DataTables::of($employee)
            ->addColumn('action', function ($q) {
                $id = encrypt($q->id);
                return '<a class="btn btn-primary btn-sm" href="' . route('company.employee.show', [$q->id]) . '"><i class="fas fa-folder"></i> View</a>
<a title="Edit"  class="btn btn-info btn-sm " href="' . route('company.employee.edit', [$q->id]) . '"><i class="fas fa-pencil-alt"></i> Edit</a>
                          <a class="btn btn-danger btn-sm delete_record" data-id="' . $q->id . '" href="javascript:void(0)"> <i class="fas fa-trash"></i> Delete</a>';
            })
            ->addColumn('image', function ($q) {

                $image = url('public/company/employee/default.png');
                if (!empty($q->image) && $q->image !== null) :
                    $image = url('public/company/employee/' . $q->image);
                endif;
                return '<img src="' . $image . '" style="width:50px; height:50px; border-radius:50%;">';
            })
            ->addColumn('fullname', function ($q) {
                return $q->name.' '.$q->lastname;
            })
            ->addColumn('email', function ($q) {
                return $q->email;
            })
            ->addColumn('role', function ($q) {
                return ucwords($q->role);
            })
            ->addColumn('phone', function ($q) {
                return $q->phone;
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
            ->rawColumns(['status', 'action', 'image'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $salarytypes = SalaryType::where('userid',Auth::user()->id)->get();
      //  dd(count($salarytypes));
        return view('company.employee.add',compact('salarytypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required',

        ];

        if (isset($request->userid)) {
            $userid = decrypt($request->userid);
            $rules['email'] = 'required|email|unique:users,email,' . $userid;
            $rules['phone'] = 'required|unique:users,phone,' . $userid;

        } else {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['phone'] = 'required|unique:users,phone';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            begin();
            try {
                $isCheck = checkValidEmail($request->email);
                if ($isCheck == false) {
                    $arr = array("status" => 400, "msg" => "This email is not allowed. Please use a valid and real email address.", "result" => array());
                    return \Response::json($arr);
                }
                $input = $request->except(['_token']);
               // $input = $request->all();
                DB::enableQueryLog();
               // dd(decrypt($request->userid));
                if (isset($request->userid)) {
                    $userid = decrypt($request->userid);
                    $employee = User::find($userid);
                    $fileName = $employee->image;
                     $msg = 'employee updated successfully.';
                }else{
                    $employee = new User;
                     $msg = 'employee added successfully.';
                }
                
                $input['role'] = 'employee';
                $fileName = '';
                if ($request->hasFile('image')) {
                    $destinationPath = public_path() . '/company/employee/';
                    $file = $request->image;
                    $fileName = time() . '.' . $file->clientExtension();
                    $file->move($destinationPath, $fileName);
                    $input['image'] = $fileName;
                }
                
                //dd($request->all());

                $employee->parentid = Auth::user()->id;
                $employee->name = $request->name;
                $employee->role = 'employee';
                $employee->lastname = $request->lastname;
                $employee->password = null;
                $employee->email_verified_at = null;
                $employee->email = $request->email;
                $employee->phone = $request->phone;
                $employee->cityid = $request->cityid ?? null;
                $employee->image = $fileName;
                $employee->save();
               // dd(DB::getQueryLog());
                $employee->employee_detail()->updateOrCreate([
                        'address' => $input['address'] ?? "",
                        'postal_code' => $input['postal_code'] ?? "",
                        'birthdate' => $input['birthdate'] ?? null,
                        'gender' => $input['gender'] ?? "",
                        'age' => $input['age'] ?? "",
                        'account_no' => $input['account_no'] ?? "",
                        'date_of_joining' => $input['date_of_joining'] ?? null,
                        'qualification' => $input['qualification'] ?? "",
                        'emergency_number' => $input['emergency_number'] ?? "",
                        'employment_status' => $input['employment_status'] ?? "",
                        'pan_number' => $input['pan_number'] ?? "",
                        'father_name' => $input['father_name'] ?? "",
                        'permanent_address' => $input['permanent_address'] ?? "",
                        'formalities' => $input['formalities'] ?? "",
                        'offer_acceptance' => $input['offer_acceptance'] ?? "",
                        'probation_period' => $input['probation_period'] ?? "",
                        'date_of_confirmation' => $input['date_of_confirmation'] ?? null,
                        'department' => $input['department'] ?? "",
                        'salary' => $input['salary'] ?? null,
                        'salarytype' => $input['salarytype'] ?? null,
                        'bank_name' => $input['bank_name'] ?? "",
                        'ifsc_code' => $input['ifsc_code'] ?? "",
                        'pf_account_number' => $input['pf_account_number'] ?? "",
                        'un_number' => $input['un_number'] ?? "",
                        'pf_status' => $input['pf_status'] ?? "",
                        'date_of_resignation' => $input['date_of_resignation'] ?? null,
                        'notice_period' => $input['notice_period'] ?? null,
                        'last_working_day' => $input['last_working_day'] ?? null,
                        'full_final' => $input['full_final'] ?? "",

                    ]);
                if(!isset($request->userid)){

                     //send welcome email with login details
                    $user_temp = User::find($employee->id);
                    $token = app('auth.password.broker')->createToken($user_temp);

                    DB::table('password_resets')->insert([
                        'email' => $input['email'],
                        'token' => $token, //str_random(60), //change 60 to any length you want
                        'created_at' => Carbon::now()
                    ]);

                    $subject = 'Your account has been created by HRMS.';
                    $folder = 'company';
                    $view = 'new_user';
                    $data = array('name' => $input['name'], 'email' => $input['email'], 'token' => $token, 'description' => 'Welcome to the HRMS. Your account is created by HRMS company team as Employee.', 'extra' => 'Your account and login details are as mentioned below:');
                    sendmail($view, $data, $subject, $folder);

                }
                commit();

                $arr = array("status" => 200, "msg" => $msg);
            } catch (\Illuminate\Database\QueryException $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                rollback();
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                rollback();
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            }
        }

        return \Response::json($arr);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = User::whereId($id)->first();
        return view('company.employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = User::with('employee_detail', 'city.state.country')->find($id);
        $salarytypes = SalaryType::where('userid',Auth::user()->id)->get();
        return view('company.employee.add', compact('employee','salarytypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //send id into store function
        return $this->store($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                $user->employee_detail()->delete();
                $user->delete();
                $arr = array("status" => 200, "msg" => 'Employee delete successfully.');
            } else {
                $arr = array("status" => 400, "msg" => 'Employee not found. please try again!');
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
            $user = User::find($id);
            if ($user) {
                $user->update(['status' => $request->status]);
                $arr = array("status" => 200, "msg" => 'Employee status change successfully.');
            } else {
                $arr = array("status" => 400, "msg" => 'Employee not found. please try again!');
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

    /**
     * Get model for add edit employee
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodal(Request $request)
    {

        $employee = array();
        if (isset($request->id) && $request->id != '') {
            $id = decrypt($request->id);
            $employee = User::with('employee_detail', 'city.state.country')->whereId($id)->first();

        }
        return view('company.employee.getmodal', compact('employee'));
    }
    public function getfilter(Request $request)
    {

        $employee = array();
        $type = $request->type;
        return view('company.employee.getfilter', compact('type'));
    }
    public function importexcel(Request $request)
    {
        $extension = '';
        if(!empty($request->file)){
            $extension = $request->file->getClientOriginalExtension();
        }

        $validator = Validator::make(
          [
              'file'      => $request->file,
              'extension' => $extension,
          ],
          [
              'file'          => 'required',
              'extension'      => 'required|in:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp',
          ]
        );
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {
                  
                if($extension == 'xlsx') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }
                // file path
                $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
                $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            
                // array Count
                $arrayCount = count($allDataInSheet);
                $flag = 0;
                $createArray = array('name', 'lastname', 'email','phone','cityid','address','postal_code','birthdate','gender','age','account_no','date_of_joining','qualification','emergency_number','employment_status','pan_number','father_name','permanent_address','formalities','offer_acceptance','probation_period','date_of_confirmation','department','salary','salarytype','bank_name','ifsc_code','pf_account_number','un_number','pf_status','date_of_resignation','notice_period','last_working_day','full_final');
                
               $makeArray = array('name' => 'namegender', 'lastname' => 'lastname', 'email' => 'email', 'email' => 'phone', 'cityid' => 'cityid',
                    'address' =>'address',
                    'postal_code' =>'postal_code',
                    'birthdate' =>'birthdate',
                    'gender' =>'gender',
                    'age' =>'age',
                    'account_no' =>'account_no',
                    'date_of_joining' =>'date_of_joining',
                    'qualification' =>'qualification',
                    'emergency_number' =>'emergency_number',
                    'employment_status' =>'employment_status',
                    'pan_number' =>'pan_number',
                    'father_name' =>'father_name',
                    'permanent_address' =>'permanent_address',
                    'formalities' =>'formalities',
                    'offer_acceptance' =>'offer_acceptance',
                    'probation_period' =>'probation_period',
                    'date_of_confirmation' =>'date_of_confirmation',
                    'department' =>'department',
                    'salary' =>'salary',
                    'salarytype' =>'salarytype',
                    'bank_name' =>'bank_name',
                    'ifsc_code' =>'ifsc_code',
                    'pf_account_number' =>'pf_account_number',
                    'un_number' =>'un_number',
                    'pf_status' =>'pf_status',
                    'date_of_resignation' =>'date_of_resignation',
                    'notice_period' =>'notice_period',
                    'last_working_day' =>'last_working_day',
                    'full_final' =>'full_final',
);
               
                $SheetDataKey = array();
                foreach ($allDataInSheet as $dataInSheet) {
                    foreach ($dataInSheet as $key => $value) {
                        if (in_array(trim($value), $createArray)) {
                            $value = preg_replace('/\s+/', '', $value);
                            $SheetDataKey[trim($value)] = $key;
                        } 
                    }
                }
                //dd($makeArray);
                $dataDiff = array_diff_key($makeArray, $SheetDataKey);

                if (empty($dataDiff)) {
                    $flag = 1;
                }
                // match excel sheet column
                if ($flag == 1) {
                    for ($i = 2; $i <= $arrayCount; $i++) {
                        
                        $name = $SheetDataKey['name'];
                        $lastname = $SheetDataKey['lastname'];
                        $email = $SheetDataKey['email'];                       
                        $phone = $SheetDataKey['phone'];                       
                        $cityid = $SheetDataKey['cityid']; 
                       //$image = $SheetDataKey['image'];                      

                        $name = $allDataInSheet[$i][$SheetDataKey['name']];
                        $lastname = $allDataInSheet[$i][$SheetDataKey['lastname']];
                        $email = $allDataInSheet[$i][$SheetDataKey['email']];
                        $phone = $allDataInSheet[$i][$SheetDataKey['phone']];
                        $cityid = $allDataInSheet[$i][$SheetDataKey['cityid']];

                        //employee details table

                        //check user exist or not 
                        $isValid = true;
                        $usercount = User::where([['email',$email],['status','active']])->count();
                        if($usercount > 0){
                            $isValid = false;
                        }
                        $isCheck = checkValidEmail($email);
                        if ($isCheck == false) {
                             $isValid = false;
                        }
                      //  dd($isValid);
                        if ($isValid) {
// DB::enableQueryLog();
                        $user = new User;
                        $user->parentid = Auth::user()->id;
                        $user->name = $name;
                        $user->lastname = $lastname;
                        $user->email = $email;
                        $user->phone = $phone;
                        $user->cityid = $cityid;
                        $user->role =  'employee';                        
                        $user->save();
                        
                        $user->employee_detail()->updateOrCreate([
                        'address' => $allDataInSheet[$i][$SheetDataKey['address']] ?? "",
                        'postal_code' => $allDataInSheet[$i][$SheetDataKey['postal_code']] ?? "",
                        'birthdate' => $allDataInSheet[$i][$SheetDataKey['birthdate']] ?? null,
                        'gender' => $allDataInSheet[$i][$SheetDataKey['gender']] ?? "",
                        'age' => $allDataInSheet[$i][$SheetDataKey['age']] ?? "",
                        'account_no' => $allDataInSheet[$i][$SheetDataKey['account_no']] ?? "",
                        'date_of_joining' => $allDataInSheet[$i][$SheetDataKey['date_of_joining']] ?? null,
                        'qualification' => $allDataInSheet[$i][$SheetDataKey['qualification']] ?? "",
                        'emergency_number' => $allDataInSheet[$i][$SheetDataKey['emergency_number']] ?? "",
                        'employment_status' => $allDataInSheet[$i][$SheetDataKey['employment_status']] ?? "",
                        'pan_number' => $allDataInSheet[$i][$SheetDataKey['pan_number']] ?? "",
                        'father_name' => $allDataInSheet[$i][$SheetDataKey['father_name']] ?? "",
                        'permanent_address' => $allDataInSheet[$i][$SheetDataKey['permanent_address']] ?? "",
                        'formalities' => $allDataInSheet[$i][$SheetDataKey['formalities']] ?? "",
                        'offer_acceptance' => $allDataInSheet[$i][$SheetDataKey['offer_acceptance']] ?? "",
                        'probation_period' => $allDataInSheet[$i][$SheetDataKey['probation_period']] ?? "",
                        'date_of_confirmation' => $allDataInSheet[$i][$SheetDataKey['date_of_confirmation']] ?? null,
                        'department' => $allDataInSheet[$i][$SheetDataKey['department']] ?? "",
                        'salary' => $allDataInSheet[$i][$SheetDataKey['salary']] ?? null,
                        'salarytype' => $allDataInSheet[$i][$SheetDataKey['salarytype']] ?? null,
                        'bank_name' => $allDataInSheet[$i][$SheetDataKey['bank_name']] ?? "",
                        'ifsc_code' => $allDataInSheet[$i][$SheetDataKey['ifsc_code']] ?? "",
                        'pf_account_number' => $allDataInSheet[$i][$SheetDataKey['pf_account_number']] ?? "",
                        'un_number' => $allDataInSheet[$i][$SheetDataKey['un_number']] ?? "",
                        'pf_status' => $allDataInSheet[$i][$SheetDataKey['pf_status']] ?? "",
                        'date_of_resignation' => $allDataInSheet[$i][$SheetDataKey['date_of_resignation']] ?? null,
                        'notice_period' => $allDataInSheet[$i][$SheetDataKey['notice_period']] ?? null,
                        'last_working_day' => $allDataInSheet[$i][$SheetDataKey['last_working_day']] ?? null,
                        'full_final' => $allDataInSheet[$i][$SheetDataKey['full_final']] ?? "",

                    ]);
                        }                      

                       // dd(DB::getQueryLog());
                    }   
                    $arr = array("status" => 200, "msg" => "Successfully imported", "result" => array());
                } else {
                    $arr = array("status" => 400, "msg" => "Please import correct file, did not match excel sheet column", "result" => array());
                }
                
                
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

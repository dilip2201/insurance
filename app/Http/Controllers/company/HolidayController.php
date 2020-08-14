<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Holiday;
use DataTables;
use Validator;

class HolidayController extends Controller
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
        return view('company.holiday.index');
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
                $createArray = array('title', 'start_date', 'end_date');
                $makeArray = array('title' => 'title', 'start_date' => 'start_date', 'end_date' => 'end_date');
                $SheetDataKey = array();
                foreach ($allDataInSheet as $dataInSheet) {
                    foreach ($dataInSheet as $key => $value) {
                        if (in_array(trim($value), $createArray)) {
                            $value = preg_replace('/\s+/', '', $value);
                            $SheetDataKey[trim($value)] = $key;
                        } 
                    }
                }
                $dataDiff = array_diff_key($makeArray, $SheetDataKey);
                if (empty($dataDiff)) {
                    $flag = 1;
                }
                // match excel sheet column
                if ($flag == 1) {
                    for ($i = 2; $i <= $arrayCount; $i++) {
                        
                        $title = $SheetDataKey['title'];
                        $start_date = $SheetDataKey['start_date'];
                        $end_date = $SheetDataKey['end_date'];                       

                        $ftitle = $allDataInSheet[$i][$title];
                        $fstart_date = $allDataInSheet[$i][$start_date];
                        $fend_date = $allDataInSheet[$i][$end_date];
                        
                       
                        $hl = new Holiday;
                        $hl->title = $ftitle;
                        $hl->start_date = date('Y-m-d',strtotime($fstart_date));
                        $hl->end_date = date('Y-m-d',strtotime($fend_date));
                        $hl->save();
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
    /**
     * @param Request $request
     * @return mixed
     */
    public function getall(Request $request)
    {

        $holiday = Holiday::orderby('id', 'desc');
        if (isset($request->status) && !empty($request->status)) {
            $holiday = $holiday->where('status',$request->status);
        }
        
        $holiday = $holiday->get();
        return DataTables::of($holiday)
            ->addColumn('action', function ($q) {
                $id = encrypt($q->id);
                return '<a title="Edit"  data-id="'.$id.'"   data-toggle="modal" data-target=".add_modal" class="btn btn-info btn-sm openaddmodal" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i> Edit</a>
                          <a class="btn btn-danger btn-sm delete_record" data-id="'.$q->id.'" href="javascript:void(0)"> <i class="fas fa-trash"></i> Delete</a>';
            })
            
            ->addColumn('title', function ($q) {
                return $q->title;
            })
            ->addColumn('date', function ($q) {
                return date('d M Y',strtotime($q->start_date)).' To '.date('d M Y',strtotime($q->end_date));
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'start_date' => 'required|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date_format:Y-m-d',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            
            try {
                
                if (isset($request->holidayid)) {
                	$holidayid = decrypt($request->holidayid);
                	$holiday = Holiday::find($holidayid);
                }else{
                	$holiday = new Holiday;
                }
            	\DB::enableQueryLog();
                $holiday->title = $request->title;
                $holiday->start_date = $request->start_date;
                $holiday->end_date = $request->end_date;
                $holiday->save();
                 dd(\DB::getQueryLog());
                $arr = array("status" => 200, "msg" => 'Holiday Added successfully');
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
     * Change status of employee active or inactive
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response send response in json
     */
    public function changestatus(Request $request)
    {

        try {
            $id = decrypt($request->id);
            $holiday = Holiday::find($id);
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

    /**
     * Get model for add edit holiday
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodal(Request $request)
    {

        $holiday = array();
        if (isset($request->id) && $request->id != '') {
            $id = decrypt($request->id);
            $holiday = Holiday::where('id',$id)->first();

        }
        return view('company.holiday.getmodal', compact('holiday'));
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
            $holiday = Holiday::find($id);
            if ($holiday) {
                $holiday->delete();
                $arr = array("status" => 200, "msg" => 'Holiday delete successfully.');
            } else {
                $arr = array("status" => 400, "msg" => 'Holiday not found. please try again!');
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
}

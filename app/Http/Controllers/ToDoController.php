<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ToDo;
use Validator;
use App\User;
use Auth;
use DataTables;
use App\ToDoLog;

class ToDoController extends Controller
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
        $users = User::whereStatus('active')->get();
        return view('admin.todos.index', compact('users'));
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
     * load datatable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getall(Request $request)
    {
        $role = auth()->user()->role;
        if(auth()->user()->role == 'super_admin'){
            $todos = ToDo::with('user')->orderby('id', 'desc');
        }
        if(auth()->user()->role == 'user' || auth()->user()->role == 'operator'){
            $todos = ToDo::with('user')->where('work_alloted_id',auth()->user()->id)->orderby('id', 'desc');
        }
        if (isset($request->date) && !empty($request->date)) {
            $todos = $todos->where('date',$request->date);
        }
        if (isset($request->due_date) && !empty($request->due_date)) {
            $todos = $todos->where('due_date',$request->due_date);
        }
        if (isset($request->work_alloted_id) && !empty($request->work_alloted_id)) {
            $todos = $todos->where('work_alloted_id',$request->work_alloted_id);
        }
        if (isset($request->status) && !empty($request->status)) {
            $todos = $todos->where('status',$request->status);
        }
        $todos = $todos->get();
        return DataTables::of($todos)
            ->addColumn('action', function ($q) {
                $id = encrypt($q->id);
                $return = '';
                if(auth()->user()->role == 'super_admin'){
                $return .= '<a title="Edit"  data-id="'.$id.'"   data-toggle="modal" data-target=".add_modal" class="btn btn-info btn-sm openaddmodal" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i></a>';
                }
                $return .= ' <a title="Due date"  data-id="'.$q->id.'"   data-toggle="modal" data-target=".add_log" class="btn btn-info btn-sm openaddmodallog" href="javascript:void(0)"><i class="fa fa-plus"></i></a>  <a title="Logs"  data-id="'.$q->id.'"   data-toggle="modal" data-target=".history_log" class="btn btn-danger btn-sm history_log_show" href="javascript:void(0)"><i class="fa fa-history" aria-hidden="true"></i></a>';
                return $return;
            })
            ->addColumn('work_alloted_id', function ($q) {
               return $q->user->name.' '.$q->user->lastname;
            })
            ->addColumn('description', function ($q) {
                $string = (strlen($q->description) > 13) ? substr($q->description,0,10).'<a href="#" data-desc_id="' . $q->id . '"  class = "get_desc">...</a>' : $q->description;
                
                 return $string;
            })
            ->addColumn('remarks', function ($q) {
                $string = (strlen($q->remarks) > 13) ? substr($q->remarks,0,10).'<a href="#" data-remark_id="' . $q->id . '"  class = "get_remark">...</a>' : $q->remarks;
                 return $string;
            })
            ->addColumn('date', function ($q) {
               return date('d M Y',strtotime($q->date));
            })
            ->addColumn('due_date', function ($q) {
               return date('d M Y',strtotime($q->due_date));
            })
            ->addColumn('status', function ($q) use($role) {
                 $return = '';
                 if(Auth::user()->role == 'super_admin'){
                    $return = '<select class="form-control changestatus" data-id ="'.$q->id.'">
                     <option value="Pending"';
                     if($q->status == 'Pending'): $return .= 'selected'; endif; $return .='>Pending</option>
                        <option value="Completed"';
                     if($q->status == 'Completed'): $return .= 'selected'; endif; $return .='>Completed</option>
                        <option value="Hold" ';
                     if($q->status == 'Hold'): $return .= 'selected'; endif; $return .='>Hold</option>
                        <option value="Prospect"';
                     if($q->status == 'Prospect'): $return .= 'selected'; endif; $return .='>Prospect</option></select>';
                    
                 }else{
                   $return = $q->status;
                 }

                 return $return;
            })
            
        ->addIndexColumn()
        ->rawColumns(['status', 'action','description','remarks'])->make(true);
    }

    public function get_desc($id)
    {
        $desc = ToDo::where('id', $id)->pluck('description')->first();
        return $desc;
    }
    public function get_remark($id)
    {
        $remark = ToDo::where('id', $id)->pluck('remarks')->first();
        return $remark;
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
            'task_name' => 'required',
            'description' => 'required',
            'due_date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {
                if (isset($request->todo_id)) {
                    $todoid = decrypt($request->todo_id);
                    $todo = ToDo::find($todoid);
                    $msg = "ToDo updated successfully.";
                }else{
                    $todo = new ToDo;
                    $todo->date = date('Y-m-d', time());
                    $msg = "ToDo added successfully.";
                }
 
                $todo->task_name = $request->task_name;
                $todo->description = $request->description;
                $todo->due_date = $request->due_date;
                $todo->remarks = $request->remarks;
                $todo->work_alloted_id = $request->work_alloted_id;

                $todo->save();
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
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodal(Request $request)
    {
        $todo = array();
        $users = User::whereStatus('active')->get();
        if (isset($request->id) && $request->id != '') {
            $id = decrypt($request->id);
            $todo = ToDo::with('user')->where('id',$id)->first();

        }
        return view('admin.todos.getmodal', compact('todo','users'));
    }
    /**
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodallog(Request $request)
    {

        $todo_id = $request->id;
        $user_id = Auth::user()->id;
        $status = ToDo::where('id',$todo_id)->first();
        return view('admin.todos.getmodallog',compact('todo_id','user_id','status'));
    }
    /**
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodalhistory(Request $request)
    {
        $histories = ToDoLog::where('to_do_id',$request->id)->orderBy('created_at','desc')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
        return view('admin.todos.historyshow',compact('histories'));
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
            'status' => 'required',
            'comment' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {
                $todolog = new ToDoLog;
                $todolog->to_do_id = $request->to_do_id;
                $todolog->user_id = Auth::user()->id;
                $todolog->status = $request->status;
                if(isset($request->date) && !empty($request->date)){
                    $todolog->next_followup_date = $request->date;    
                }
                $todolog->comment = $request->comment;
                $todolog->save();

                if(isset($request->date) && !empty($request->date)){
                    Todo::where('id',$request->to_do_id)->update(['status' => $request->status,'due_date'=>$request->date]);
                 }else{
                    Todo::where('id',$request->to_do_id)->update(['status' => $request->status]);
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
     * status change
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function changestatus(Request $request) {
        try {


            $log = new ToDoLog;
            $log->to_do_id = $request->id;
            $log->user_id = Auth::user()->id;
            $log->status = $request->status;
            $log->comment = "Your status change successfully as ".$request->status.".";
            $log->save();


            $user = ToDo::find($request->id)->update(['status'=>$request->status]);
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
}

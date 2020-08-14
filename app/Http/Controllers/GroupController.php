<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use DataTables;
use Validator;

class GroupController extends Controller
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
        return view('admin.group.index');
    }

    public function store(Request $request){
       
            
        $rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {

                if(isset($request->groupid) && !empty($request->groupid)){
                    $group = Group::find($request->groupid);
                }else{
                    $group = new Group;    
                }
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


        /**
     * Get all the group
     * @param Request $request
     * @return mixed
     */
    public function getall(Request $request)
    {
        $users = Group::withCount('clients')->orderby('id', 'desc');
        $users = $users->get();
        
        return DataTables::of($users)
        ->addColumn('action', function ($q) {
            $id = $q->id;
            $return = '<a title="Edit"  data-id="'.$id.'"  data-name="'.$q->name.'"  data-code="'.$q->code.'"  class="btn btn-info btn-sm editgroup" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i></a>';
            if($q->clients_count == 0){
                $return .= ' | <a class="btn btn-danger btn-sm deletegroup" href="javascript:void(0)"  data-id="'.$id.'" ><i class="fa fa-trash"></i></a>';
            }
            

            return $return;
        })
        ->addIndexColumn()
        ->rawColumns([])->make(true);
    }
   
    public function delete(Request $request){

        try {
            $id = $request->id;
            Group::find($id)->delete();
            
            $arr = array("status" => 200, "msg" => 'Group deleted successfully.');
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

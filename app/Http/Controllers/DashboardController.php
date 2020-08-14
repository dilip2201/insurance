<?php

namespace App\Http\Controllers;

use App\LeaveType;
use App\User;
use Illuminate\Http\Request;
use App\Holiday;
use App\LeaveApply;
use App\SalaryType;
use Auth;
use App\Client;
use App\Group;
use App\ToDo;
use App\Work;
use Carbon\Carbon;
class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {      
       // $start = date('z') + 1 - 7;
      //  $end = date('z') + 1 + 7;

        //$birthdays =   Client::whereRaw("DAYOFYEAR(date_of_birth) BETWEEN $start AND $end")->get();
        $birthdays =   Client::whereMonth('date_of_birth',date('m'))->get();

        $clients = Client::count();
        $groups = Group::count();
        $users = User::count();
        $works = Work::count();
        $open = Work::where('status','open')->count();
        $close= Work::where('status','closed')->count();
        $todo = ToDo::where('work_alloted_id',auth()->user()->id)->count();
        $todos = ToDo::count();
        $completed = ToDo::where('status','Completed')->count();
        $pending = ToDo::where('status','Pending')->count();
        $hold = ToDo::where('status','Hold')->count();
        $prospect = ToDo::where('status','Prospect')->count();
        $completeds = ToDo::where('work_alloted_id',auth()->user()->id)->where('status','Completed')->count();
        $pendings = ToDo::where('work_alloted_id',auth()->user()->id)->where('status','Pending')->count();
        $holds = ToDo::where('work_alloted_id',auth()->user()->id)->where('status','Hold')->count();
        $prospects = ToDo::where('work_alloted_id',auth()->user()->id)->where('status','Prospect')->count();
        
        return view('admin.dashboard.index',compact('clients','groups','users','completed','pending','hold','prospect','works','todo','completeds','pendings','holds','prospects','todos','open','close','birthdays'));
    }
}

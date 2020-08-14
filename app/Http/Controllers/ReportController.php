<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business;
use App\ClientBusiness;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Client;
use PDF;
class ReportController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $businesses = Business::get();
        return view('admin.reports.index',compact('businesses'));
    }

    public function downloadpdf(Request $request)
    {
    if($request->type == 'taken'){
        
        $takens = Client::with('group')->whereHas('business' , function($query) use ($request){
            $query->where('business_id', '=',$request->buisness);
        })->get();
        $business = Business::where('id',$request->buisness)->first();
        $name = ucwords(str_replace('_', ' ', $business->name));

        $type = $request->type;

        if($request->submittype == 'pdf') {
            $pdf = PDF::loadview('admin.reports.buisnessclients',compact('takens','name','type'));
            return $pdf->download(''. $request->type.'-'.$business->name.'-'.'works.pdf');
        }else if ($request->submittype == 'excel'){

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Client Name');
            $sheet->getColumnDimension('A')->setAutoSize(true);

            $sheet->setCellValue('B1', 'Group');
            $sheet->getColumnDimension('B')->setAutoSize(true);

            $sheet->setCellValue('C1', 'Mobile No.');
            $sheet->getColumnDimension('C')->setAutoSize(true);

            $sheet->setCellValue('D1', 'Email');
            $sheet->getColumnDimension('D')->setAutoSize(true);

            $sheet->setCellValue('E1', 'Status');
            $sheet->getColumnDimension('E')->setAutoSize(true);

            $sheet->freezePaneByColumnAndRow(1, 2);
            if (!empty($takens)) {
                $i = 2;
                foreach ($takens as $taken) {


                    $sheet->setCellValue('A' . $i, $taken->name_salutation.' '.$taken->first_name.' '.$taken->last_name);
                    $sheet->setCellValue('B' . $i, $taken->group->name);
                    $sheet->setCellValue('C' . $i,  $taken->mobile_number );
                    $sheet->setCellValue('D' . $i, $taken->email );
        
                    $sheet->setCellValue('E' . $i,  ucwords($taken->status));
                   
                    $i++;
                }
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. $request->type.'-'.$business->name.'-'.'works.xlsx"');
            $writer->save("php://output");

        }
    }elseif($request->type == 'not_taken'){

        $business = Business::where('id',$request->buisness)->first();
        $name = ucwords(str_replace('_', ' ', $business->name));

        $type = ucwords(str_replace('_', ' ',  $request->type));

        $takens = Client::with('group')->whereDoesntHave('business' , function($query) use ($request){
            $query->where('business_id', '=',$request->buisness);
        })->get();

        if($request->submittype == 'pdf') {
            $pdf = PDF::loadview('admin.reports.buisnessclients',compact('takens','business','type','name'));
            return $pdf->download(''. $request->type.'-'.$business->name.'-'.'works.pdf');
        }else if ($request->submittype == 'excel'){

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Client Name');
            $sheet->getColumnDimension('A')->setAutoSize(true);

            $sheet->setCellValue('B1', 'Group');
            $sheet->getColumnDimension('B')->setAutoSize(true);

            $sheet->setCellValue('C1', 'Mobile No.');
            $sheet->getColumnDimension('C')->setAutoSize(true);

            $sheet->setCellValue('D1', 'Email');
            $sheet->getColumnDimension('D')->setAutoSize(true);

            $sheet->setCellValue('E1', 'Status');
            $sheet->getColumnDimension('E')->setAutoSize(true);

            $sheet->freezePaneByColumnAndRow(1, 2);
            if (!empty($takens)) {
                $i = 2;
                foreach ($takens as $taken) {


                    $sheet->setCellValue('A' . $i, $taken->name_salutation.' '.$taken->first_name.' '.$taken->last_name);
                    $sheet->setCellValue('B' . $i, $taken->group->name);
                    $sheet->setCellValue('C' . $i,  $taken->mobile_number );
                    $sheet->setCellValue('D' . $i, $taken->email );
        
                    $sheet->setCellValue('E' . $i,  ucwords($taken->status));
                   
                    $i++;
                }
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. $request->type.'-'.$business->name.'-'.'works.xlsx"');
            $writer->save("php://output");

        }
    }
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
}

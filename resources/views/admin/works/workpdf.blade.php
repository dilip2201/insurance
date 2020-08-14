<html>
   <head>
      <style>
         /**
         Set the margins of the page to 0, so the footer and the header
         can be of the full height and width !
         **/
         @page {
         margin: 0cm 0cm;
         }
         table, th, td {
         border: 1px solid black;
         border-collapse: collapse;
         /*font-weight: 100;*/
         font-size: 12px;
         }
         th, td {
         padding: 5px;
         text-align: left;
         /*font-weight: 100;*/
         font-size: 12px;
         }
         .termsandcondition p{
         margin:0px;
         }
         /** Define now the real margins of every page in the PDF **/
         body {
         font-family: Arial, sans-serif;
         margin-top: 50px;
         margin-left: 10px;
         margin-right: 10px;
         margin-bottom: 110px;
         }
         /** Define the header rules **/
         header {
         position: fixed;
         text-align: right;
         height: 100px;
         padding-top: 25px;
         padding-right: 50px;
         }
         /** Define the footer rules **/
         footer {
         position: fixed;
         bottom: 10px;
         left: 15px;
         right: 15px;
         height: 115px;
         }
         .toppart{
         width: 100%;
         display: block;
         margin-top: 15px;
         font-size: 14px;
         }
         .toppartwithoutmargin{
         width: 100%;
         display: block;
         font-size: 14px;
         }
         .fontbold{
         font-weight: 600;
         }
         .servicespart{
         background: #eee;
         margin-top: 10px;
         font-size: 14px;
         padding: 4px;
         }
         main{
         padding-left: 30px;
         padding-right: 30px;
         }
         .colorblue{
         color: #00add8;
         border-bottom: 1px solid #00add8;
         }
         .assementdescription{
         font-style: italic;
         font-size: 14px;
         }
         .blackunderline{
         color: #000;
         border-bottom: 1px solid #000;
         font-weight: 600;
         }
         .termsandcondition{
         font-size: 12px;
         }
         * {
         box-sizing: border-box;
         }
         .column {
         float: left;
         width: 30.33%;
         padding: 10px;
         height: 150px; /* Should be removed. Only for demonstration */
         }
         /* Clear floats after the columns */
         .row:after {
         content: "";
         display: table;
         clear: both;
         }
      </style>
   </head>
   <body>

      <main>
               <div class="" >
               @if(!empty($namework))
               <b>Work</b> : {{ ucwords(rtrim($namework,'-')) }}
               <br>
               @endif

               @if(!empty($nameclient))
               <b>Client Name</b> : {{ rtrim($nameclient,'-') }}
               <br>
               @endif

               @if(!empty($namegroup))
               <b>Group</b> : {{ rtrim($namegroup,'-') }}
               <br>
               @endif
            </div>
     
               <table class="table table-bordered" style="width: 100%;">
                  <thead>
                     <tr>
                        <th><h3><b>Client Name</b></h3></th>
                        <th><h3><b>Work</b></h3></th>
                        <th><h3><b>Company</b></h3></th>
                        <th><h3><b>Document No.</b></h3></th>
                        <th><h3><b>Amount</b></h3></th>
                        <th><h3><b>Start Date</b></h3></th>
                        <th><h3><b>End Date</b></h3></th>
                        <th><h3><b>Period</b></h3></th>
                        <th><h3><b>Status</b></h3></th>
                     </tr>
                  </thead>
                  <tbody>
                  @foreach($works as $work)
                     <tr>
                        <td>{{ $work->client->name_salutation }}{{ $work->client->first_name }} {{ $work->client->last_name }} </td>
                        <td>{{ $work->work }}</td>
                        <td>{{ $work->company->name }}</td>
                        <td>{{ $work->unique_number }}</td>
                        <td>{{ $work->amount}}</td>
                        <td>{{date('D M Y',strtotime( $work->start_date)) }}</td>
                        <td>{{date('D M Y',strtotime( $work->end_date)) }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $work->period)) }}</td>
                       

                        @if($work->status == 'open')
                        <td>Open</td>
                        @elseif($work->status == 'closed')
                        <td>Closed</td>
                        @endif
                     </tr>
                     @endforeach
                  </tbody>
               </table>
      

      </main>
   </body>
</html>
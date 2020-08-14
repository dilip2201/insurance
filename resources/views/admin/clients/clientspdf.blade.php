
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
            @if(!empty($type) && !empty($name))
            <b>Type :</b> {{ ucwords($type)}} <br>
            
            <b>Buisness :</b> {{ $name }}<br>
            @endif
               <table class="table table-bordered" style="width: 100%;">
                  <thead>
                     <tr>
                        <th><h3><b>Sr. No.</b></h3></th>
                        <th><h3><b>Client Name</b></h3></th>
                        <th><h3><b>Group</b></h3></th>
                        <th><h3><b>Mobile No.</b></h3></th>
                        <th><h3><b>Email</b></h3></th>
                        <th><h3><b>Status</b></h3></th>
                     </tr>
                  </thead>
                  <tbody>

                  @if(!empty($users))
                  @foreach($users as $user)
                  <tr>
                     <td>{{ $user->client_number ?? ''}}</td>
                     <td>{{ $user->name_salutation  ?? '' }}{{ $user->first_name ?? '' }} {{ $user->last_name ?? '' }} </td>
                     <td>{{ $user->group->name ?? ''}}</td>
                     <td>{{ $user->mobile_number ?? '' }}</td>
                     <td>{{ $user->email  ?? ''}}</td>
                     @if($user->status == 'active')
                        <td>Active</td>
                           @elseif($user->status == 'inactive')
                        <td>Inactive</td>
                     @endif
                  </tr>
                  @endforeach
                  @endif
                  </tbody>
               </table>
      

      </main>
   </body>
</html>
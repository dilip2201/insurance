<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BrodexTrident</title>
</head>
<body>
<center>
    <table width="800" align="center" border="1" style="border:1px solid #cccccc;" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
        <tr>
            <td align="center" valign="top" id="bodyCell">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" valign="top" id="templateHeader" data-template-container style="background-color:#00add8;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                <tr>
                                    <td valign="top" class="headerContainer">
                                        <table class="mcnImageBlock" style="min-width:100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody class="mcnImageBlockOuter">
                                            <tr>
                                                <td style="padding:9px" class="mcnImageBlockInner" valign="top">
                                                    <table class="mcnImageContentContainer" style="min-width:100%;" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
                                                        <tbody>
                                                        <tr>
                                                            <td class="mcnImageContent" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;" valign="top">
                                                              <h2>HRMS</h2>
                                                                {{--<img src="{{ url('public/admin/img/brodex/logo.png')}}" style="padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" height="80px" width="auto" align="middle">--}}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" id="templateBody" data-template-container>
                            <table align="center" border="0" cellpadding="0" cellspacing="0" max-width="100%" class="templateContainer" style="padding-bottom: 30px;">
                                <tr>
                                    <td valign="top" class="bodyContainer">
                                        <table class="mcnTextBlock" style="min-width:100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                                <td class="mcnTextBlockInner"  valign="top">
                                                    <table style="max-width:100%; min-width:100%;" class="mcnTextContentContainer" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
                                                        <tbody>
                                                        <tr>
                                                            <td class="mcnTextContent" style="padding-top:10px; padding-right:30px; padding-left:30px;" valign="top">
                                                                <h3 class="null" style="text-align: left;">Hi {{ $data['name'] }},</h3>

                                                           </span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="mcnImageBlock" style="min-width:100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody class="mcnImageBlockOuter">
                                            <tr>
                                                <td style="padding:9px 30px 9px 30px;" class="mcnImageBlockInner" valign="top">
                                                    <table class="mcnImageContentContainer" style="min-width:100%;" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
                                                        <tbody>
                                                        <tr>
                                                            <td style='border:1px solid #cccccc ; padding:5px;'>Your Name</td>
                                                            <td style='border:1px solid #cccccc ; padding:5px;'>{{ $data['name'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style='border:1px solid #cccccc ; padding:5px;'>Email Address</td>
                                                            <td style='border:1px solid #cccccc ; padding:5px;'>{{ $data['email'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style='border:1px solid #cccccc ; padding:5px;'>Set Password</td>
                                                            <td style='border:1px solid #cccccc ; padding:5px;'><a href="{{ URL::to('password/reset/'.$data['token']) }}">Set Passsword</a></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" id="templateFooter" data-template-container style="background-color: #00add8;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                <tr>
                                    <td valign="top" class="footerContainer">
                                        <table class="mcnTextBlock" style="min-width:100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                                <td class="mcnTextBlockInner" style="padding-top:9px;" valign="top">
                                                    <table style="max-width:100%; min-width:100%;" class="mcnTextContentContainer" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
                                                        <tbody>
                                                        <tr>
                                                            <td class="mcnTextContent" style="padding-top:0px; padding-right:18px; padding-bottom:9px; padding-left:18px;" valign="top">
                                                                <div style="text-align: center;">
                                                                    <div class="contact_detail"><a href="{{ url('/') }}" style="color: #fff; text-decoration:none;">HRMS</a></div>
                                                                    <div class="contact_detail"><span style="color: #fff;">The Old Council Chambers, 5759 Spring Street </span></div>
                                                                    <div class="contact_detail" style="color: #fff;"><span>
                                                                  <span style="color: #fff;">01424 741245</span>
                                                                  &nbsp;&nbsp;&nbsp; | &nbsp; <a href="mailto:info@BrodexTrident.com" style="color: #FFFFFF;text-decoration: none;"> info@hrms.com</a></span>
                                                                    </div>
                                                                    <div class="contact_detail">
                                                                        &nbsp;
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</center>
</body>
</html>

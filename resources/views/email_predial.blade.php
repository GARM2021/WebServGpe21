<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Guadalupe N.L.</title>
    <style type="text/css">
        .content,.content-wrap{padding:20px}.footer,.footer a{color:#999}img{max-width:100%}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;height:100%;line-height:1.6}.body-wrap{background-color:#f6f6f6;width:100%}.container{display:block!important;max-width:90%!important;margin:0 auto!important;clear:both!important}.content{margin:0 auto;display:block}.main{background:#fff;border:1px solid #e9e9e9;border-radius:3px}.content-block{padding:0 0 20px}.header{width:100%;margin-bottom:20px}.footer{width:100%;clear:both;padding:20px}.footer a,.footer p,.footer td,.footer unsubscribe{font-size:12px}@media only screen and (max-width:640px){.container,.invoice{width:100%!important}.content,.content-wrap{padding:10px!important}}
    </style>
</head>

<body>

<table class="body-wrap">

    <tr>
        <td></td>
        <td class="container" width="90%">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-wrap aligncenter">

                            <table width="100%" cellpadding="0" cellspacing="0">
                                @if(@$logo != "")
                                    <tr>
                                        <td align="center"><img src="{!! $logo !!}" style="max-height: 150px;"></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="content-block" style="font-family: Arial; font-size: 16px;">
                                        {!! $content !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        &nbsp;
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
                    <table width="100%">
                        <tr>
                            <td class="aligncenter content-block">&nbsp;</td>
                        </tr>
                    </table>
                </div></div>
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>
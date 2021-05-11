<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qwickserv</title>

    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <style>
        *{
            font-family: Gilroy-Medium, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        .message-body {
            color: #455065;
            font-size: 16px;
            padding: 10px 0;
            line-height: 160%;
        }
        .message-title {
            font-size: 20px;
        }

        .message-salutation {
            line-height: 150%;
            color: #455065;
            font-size: 24px;
        }
        .bold {
            font-weight: bold;
        }
        .text-custom {
            color: #0463F5;
        }

        .text-gray {
            color: #455065;
        }

        .highlight {
            width: 80%;
            margin: 0px auto;
            font-size: 26px;
        }
        ul.social-media {
            display: block;
            margin: 0 auto;
        }
        ul.social-media li {
            display: inline-block;
            padding:0 20px;
        }
        a[href] {
            color: #0463F5;
        }
        /* medium device and bbelow */
        @media (max-width: 768px) {
            table{
                width: 100%;
            }
            ul.social-media li {
                display: inline-block;
                padding:0 4px;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background: #E4E4E4;">
    <table cellpadding="0"  cellspacing="0" width="650" style="margin:40px auto; background: #fff; text-align: center;">
        <!-- email header -->
        <tr style="margin-bottom: 60px!important;">
            <td id="email-head" style="text-align: center; border-radius: 10px 10px 0px 0px; background: #fff;">
                <table width="95%" style="margin:0 auto;">
                    <tr>
                        <td style="border-bottom: 1px solid #E4E4E4; padding: 40px; margin: 10px auto;">
                            <a href="https://qwickserv.com/">
                                <img src="{{asset('img/icon.svg')}}" width="50%">
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- end of email header -->

        <!-- email content -->
        <tr>
            <td>
                <table width="100%" style="padding: 40px 20px; margin: 0 auto;">
                    <tr>
                        <td>
                            <p class="message-salutation">Hello <span class="bold">{{ $business->name}}</span></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="message-title text-gray">We are thrilled to have you on board our platform and your business is now being reviewed.</p>
                            <p class="message-title text-gray">You will be notified of your business approval status shortly.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- end of email content -->

        <!-- email footer -->
        <tr>
            <td>
                <table width="95%" style="margin: 0 auto;">
                    <tr>
                        <td style="border-top: 1px solid #e4e4e4; padding: 50px 20px">
                            <table width="100%">
                                <tr>
                                    <td>
                                        <p>
                                            <a style="text-decoration: none; color: #242424B3; font-size: 22px;" href="https://www.qwickserv.com">www.qwickserv.com</a>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:20px"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <ul class="social-media" style="list-style: none; text-align: center;">
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('img/instagram-logo.svg')}}">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('img/youtube-logo.svg')}}">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('img/facebook-logo.svg')}}">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('img/twitter-logo.svg')}}">
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:20px"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>© 2021 QwickServ. All rights reserved</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- end of email footer -->

    </table>
</body>
</html>
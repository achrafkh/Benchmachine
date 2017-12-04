<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style type="text/css">
        table{
            font-family: arial;
            border-collapse: collapse;
            font-size: 0;
            font-weight: 400;
            color: #9f9e9e;
            text-align: left;
        }
        ul{
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .title{
            font-size: 14px;
            color: #4d4d4d;
            font-weight: 100;
        }
        .txt{
            font-size: 14px;
        }
        .table th{
            font-size: 12px;
            font-weight: bold;
            color: #4d4d4d;
            padding: 10px;
            text-transform: uppercase;
        }
        .table > thead > tr, .table > tbody > tr{
            border-bottom: 1px solid #ecebeb;
        }
        .table > tbody > tr > td{
            font-size: 12px;
            font-weight: bold;
            padding: 10px;
            text-align: center;
        }
        .fb-img{
            width: 40px;
            border-radius: 3px;
        }
        .fb-name{
            font-size: 13px;
            color: #4d4d4d;
            font-weight: bold;
            margin: 3px 0;
        }
        .fb-id{
            font-size: 12px;
            font-weight: bold;
            margin: 3px 0;
        }
        .view-more{
            background-color: #ff7200;
            display: inline-block;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            padding: 12px 25px;
            border-radius: 3px;
            text-transform: uppercase;
            text-decoration: none;
        }
        .copyright{
            font-size: 11px;
            line-height: 16px;
            color: #aeaeae;
            text-align: center;
        }
        .copyright a{
            color: inherit;
        }
        .social-media{
            margin: 0 3px;
        }
    </style>

</head>
<body>
    <table width="100%" bgcolor="#f0f1f1">
        <tbody>
            <tr>
                <td style="padding: 50px 0;">
                    <table width="550" align="center" bgcolor="#fff">
                        <tbody>
                            <tr>
                                <td height="140" background="{{ url('/mail/banner-bg.jpg') }}" valign="top" style="padding:30px;">
                                    <a href="http://kpeiz.digital/">
                                        <img src="{{ url('/mail/logo.png') }}">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 15px 40px;">
                                    <h1 class="title">
                                        Hello, <b>Foulen</b>
                                    </h1>
                                    <p class="txt">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod incididunt ut labore et dolore magna aliqua. Ut enim ad minim.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0 40px;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Facebook Pages</th>
                                                <th>Fans</th>
                                               <!--  <th>Interactions</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($benchmark->accounts as $account)
                                            <tr>
                                                <td width="100%">
                                                    <table width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td width="1" style="padding-right: 10px;">
                                                                    <img class="fb-img" src="{{ $account->image }}">
                                                                </td>
                                                                <td>
                                                                    <ul>
                                                                        <li class="fb-name">{{ $account->title }}</li>
                                                                        <li class="fb-id">{{ $account->label }}</li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>{{ number_shorten(getLikes($account->real_id),1 ) }}</td>
                                               <!--  <td>709 791</td> -->
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding: 40px;">
                                    <a class="view-more" href="{{ url('/benchmarks/'.$benchmark->id) }}">
                                        View full Benchmark
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="550" align="center">
                        <tbody>
                            <tr>
                                <td style="padding: 15px 0 0">
                                    <p class="copyright">
                                        Please send any feedback or bug reports to <a href="contact@kpeiz.digital">contact@kpeiz.digital</a>
                                        <br>
                                        @Kpeiz Inc. <a href="https://www.facebook.com/Kpeiz/">Unsubscribe</a>
                                        <br>
                                        Avenue Fattouma Bourguiba, 2036 Tunis, Tunisia
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <a class="social-media" href="https://www.facebook.com/Kpeiz/">
                                        <img src="/mail/facebook-icon.png">
                                    </a>
                                    <a class="social-media" href="https://twitter.com/kpeiz_digital">
                                        <img src="/mail/twitter-icon.png">
                                    </a>
                                    <a class="social-media" href="https://www.instagram.com/kanalytik/">
                                        <img src="/mail/instagram-icon.png">
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>

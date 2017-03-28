<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Cinecitt&agrave; World - Services Cinecitt&agrave; - Cliente</title>
    <style>
        .table { display: table; width: 100%; border-collapse: collapse; }
        .table-row { display: table-row; }
        .table-cell { display: table-cell; border: 0px solid black; padding: 0.4em; }
        .title { padding: 0; font-size:1em;}
        .title_2{ padding: 0; font-size:2em;}
        .bottom { clear:both; border-bottom: 1px solid black;}
        .bordertop { clear:both; border-top: 1px solid black;}
        .border {  clear:both; border: 1px solid black;}
        .noborder {  clear:both; border: 0px solid black;}
        *{ font-family: DejaVu Sans; font-size: 11px;}
        .fifty { width: 50%;}
        .left { width: 48%;}
        .right { width: 50%; padding-left: 5%;}
    </style>
</head>

<body>
    <div id="app">
        <div class="table">
            <div class="table-row">
                <div class="table-cell left">
                    <img width="300px" src="../public/img/logo_ccw_2.png"/>
                </div>
                <div class="table-cell right">
                    <p>Cinecitt&agrave; World S.p.A.</p>
                    <p style="font-size:8px">Via di Castel Romano, 200 - 00128  ROMA  Tel. +39 06 4041.1501
                        www.cinecittaworld.it  - info@cinecittaworld.it <br>
                     C.F., P.IVA, n&deg; iscrizione Registro delle Imprese di Roma 13164451000 - REA 1427590 <br>
                     Capitale sociale deliberato &euro; 9.522.222,00, interamente sottoscritto e versato per<br>
                     &euro; 3.222.222,00</p>
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</body>
</html>

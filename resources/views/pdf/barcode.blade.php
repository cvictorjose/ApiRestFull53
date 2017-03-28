@extends('pdf.app')
@section('content')
    <body>
    <?php
    echo $product;
    //echo $var2=DNS1D::getBarcodeHTML($var, "C128");
    ?>
    <div>{!!  DNS1D::getBarcodeHTML($product, "C128",2,33) !!}</div>
    <div>{!!  DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",13,53) !!}</div>
@endsection




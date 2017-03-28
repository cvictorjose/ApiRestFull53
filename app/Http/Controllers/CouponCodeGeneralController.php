<?php

namespace App\Http\Controllers;

use App\CouponCodeGeneral;
use Illuminate\Http\Request;

class CouponCodeGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Get All Tickets
        return response()->json(['data'=>CouponCodeGeneral::all()]);
    }
}

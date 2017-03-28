<?php

namespace App\Http\Controllers;

use App\CouponCodeSingle;
use Illuminate\Http\Request;

class CouponCodeSingleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Get All Tickets
        return response()->json(['data'=>CouponCodeSingle::all()]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function show()
    {
    	 return response()->json(['posts'=>DB::table('shows')
            ->join('melas', 'shows.mela_id', '=', 'melas.mela_id')
            ->join('prasanghas','shows.prasangha_id','=','prasanghas.prasangha_id')
            ->whereDate('show_date','=',\Carbon\Carbon::now()->toDateString())
            ->select('shows.*','melas.mela_name','melas.mela_pic','prasanghas.prasangha_name')
            ->get()]);
    }
    public function getComments($pname,$sid)
    {
        return response()->json(['posts'=>DB::table('reviews')
              ->join('users','users.id','=','reviews.user_id')
              ->join('shows','shows.show_id','=','reviews.show_id')
              ->select('reviews.*','users.name')
              ->where('reviews.show_id','=',$sid)
              ->orderBy('reviews.created_at')->paginate(5)]);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index(){
        return view('index');
    }

    public function store(Request $request){

        $user_id = Auth::id();
        $form = [
            'user_id' => $user_id,
            'data' => $request->data
        ];
        Attendance::create($form);
        return response()->json([
            'data' => $request->data,
        ], 200);

    }

    public function show(Request $request){

        $today = Carbon::today();
        $attendances = Attendance::whereDate('created_at', $today)->with('user')->get();
        return view('teacher.index', compact('attendances','today'));
    }

}

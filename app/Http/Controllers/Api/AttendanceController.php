<?php

namespace App\Http\Controllers\Api;

use App\Attendance;
use App\Http\Controllers\Controller;
use App\Repositories\AttendanceRepository;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $attendance;

    public function __construct(AttendanceRepository $attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attendance = $this->attendance->getAttendanceList($request);

        $result = [
            'message' => 'attendance successfully retrieved',
            'attendance' => $attendance
        ];

        return response()->json($result, $this->attendance->status, [], JSON_PRETTY_PRINT);
    }
    public function getAuthAttendance(Request $request)
    {
        $attendance = $this->attendance->getAuthUserAttendance();

        $result = [
            'message' => 'attendance successfully retrieved',
            'attendance' => $attendance
        ];

        return response()->json($result, $this->attendance->status, [], JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attendance = $this->attendance->storeAttendance($request);

        $result = [
            'message' => $request->status == 'in' ? 'You have signed in successfully.' : 'You have signed out successfully.',
            'attendance' => $attendance
        ];

        return response()->json($result, $this->attendance->status, [], JSON_PRETTY_PRINT);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}

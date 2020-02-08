<?php

namespace App\Http\Controllers;

use App\Inuquiries;
use App\Mail\ClentsInquiryNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class InquiriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $client = new Inuquiries();

        DB::table(function () use ($client, $request) {
            $client->name    = $request->name;
            $client->email   = $request->email;
            $client->message = $request->message;

            $client->save();

            Mail::to(env('MAIL_ADMIN'))->send(new ClentsInquiryNotification($client));
        });

        Session::flash('flash_message', 'Your Inquiry has been submitted successfully.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inuquiries  $inuquiries
     * @return \Illuminate\Http\Response
     */
    public function show(Inuquiries $inuquiries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inuquiries  $inuquiries
     * @return \Illuminate\Http\Response
     */
    public function edit(Inuquiries $inuquiries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inuquiries  $inuquiries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inuquiries $inuquiries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inuquiries  $inuquiries
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inuquiries $inuquiries)
    {
        //
    }
}

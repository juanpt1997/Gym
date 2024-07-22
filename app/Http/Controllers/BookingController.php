<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduledClass;
use Illuminate\Database\Eloquent\Builder;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = auth()->user()->bookings()->upcoming()->oldest('date_time')->get(); /* Replaced by the scope query */

        return view('member.upcoming', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $scheduledClasses = ScheduledClass::upcoming() /* Replaced by the scope query */
            ->with('classType', 'instructor') /* Eager loading */
            ->notBooked()
            /* this way we are not showing a class that was already booked by the same member */
            /* replaced by a scoped */
            ->oldest('date_time')
            ->get();
        return view('member.book', compact('scheduledClasses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        auth()->user()->bookings()->attach($request->scheduled_class_id);

        return redirect()->route('booking.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        auth()->user()->bookings()->detach($id);

        return redirect()->route('booking.index');
    }
}

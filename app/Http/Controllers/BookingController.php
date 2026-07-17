<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\FacilityStoreRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of pending bookings.
     */
    public function pending()
    {
        $filters = Request::only(['search', 'status', 'trashed', 'user_id', 'facility_id', 'reviewed_by_id']);
        $filters['status'] = 'pending';
        $bookings = Booking::query()->orderBy('created_at', 'desc')->filter($filters)->paginate(10)->appends(Request::all());

        return Inertia::render('bookings/pending', [
            'bookings' => $bookings,
            'filters' => $filters
        ]);
    }

    /**
     * Display a listing of user's bookings.
     */
    public function user(Request $request)
    {
        $filters = Request::only(['search', 'status', 'trashed', 'user_id', 'facility_id', 'reviewed_by_id']);
        $filters['user_id'] = $request->user()->id;
        $bookings = Booking::query()->orderBy('created_at', 'desc')->filter($filters)->paginate(10)->appends(Request::all());

        return Inertia::render('bookings/user', [
            'bookings' => $bookings,
            'filters' => $filters
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function book(Request $request)
    {
        Booking::factory()->create([
            'facility_id' => $request->facility_id,
            'booked_by_id' => $request->user()->id,
            'booked_at' => now(),
            'status' => 'pending'
        ]);

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Booking created.')]);
        return to_route('bookings.user');
    }

    /** 
     * Review a booking.
     */
    public function review(Booking $booking, Request $request)
    {
        $booking->status = $request->status;
        $booking->reviewed_by_id = $request->user()->id;
        $booking->reviewed_at = now();
        $booking->save();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Booking reviewed.')]);
        return to_route('bookings/pending');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}

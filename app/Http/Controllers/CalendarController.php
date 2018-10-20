<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use \Eluceo\iCal\Component\Calendar;
use \Eluceo\iCal\Component\Event;

class CalendarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $cal = new Calendar('-//CALENDAR//EVENTS//EN');
        $cal->setMethod('PUBLISH');

        $user->donotdisturbs->each(function($dnd) use (&$cal) {
            $event = new Event();
            $event
                ->setUniqueId($dnd->id)
                ->setDtStart(new \DateTime($dnd->start))
                ->setDtEnd(new \DateTime($dnd->end))
                ->setSummary($dnd->reason ?? 'Do Not Disturb');
            $cal->addComponent($event);
        });

        return response($cal->render())
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="'.$user->id.'.ics"');
    }
}

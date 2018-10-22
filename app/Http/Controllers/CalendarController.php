<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use \Eluceo\iCal\Component\Calendar;
use \Eluceo\iCal\Component\Event;

class CalendarController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $cal = new Calendar('-//CALENDAR//EVENTS//EN');
        $cal->setMethod('PUBLISH');

        $user->donotdisturbs->each(function($dnd) use (&$cal, &$user) {
            $event = new Event();
            $event
                ->setUniqueId($dnd->id)
                ->setDtStart(new \DateTime($dnd->start_time))
                ->setDtEnd(new \DateTime($dnd->end_time))
                ->setSummary($dnd->reason ?? 'Do Not Disturb')
                // ->setOrganizer($user->name)
                ->setSequence(strtotime($dnd->updated_at));
            $cal->addComponent($event);
        });

        $user->shifts->each(function($shift) use (&$cal) {
            $event = new Event();
            $event
                ->setUniqueId($shift->id)
                ->setDtStart(new \DateTime($shift->start_time))
                ->setDtEnd(new \DateTime($shift->end_time))
                ->setSummary($shift->name)
                ->setDescription($shift->description . '\n\nShift Lead: ' . $shift->user->name)
                // ->setOrganizer($shift->user->name)
                ->setLocation($shift->location->name ?? 'Ravensbourne')
                ->setSequence(strtotime($shift->updated_at));
            $cal->addComponent($event);
        });

        return response($cal->render())
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'inline; filename="'.$user->id.'.ics"');
    }
}

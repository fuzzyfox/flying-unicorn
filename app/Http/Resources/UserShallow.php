<?php

namespace App\Http\Resources;


class UserShallow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rtn = [
            'id'         => (string)$this->id,
            'name'       => (string)$this->name,
            'username'   => (string)$this->username,
            'is_super'   => (bool)$this->is_super,
        ];

        if ($request->user()->is_super) {
            if ($this->pivot->checkin) {
                $rtn['checkin'] = $this->pivot->checkin ?? false;
                $rtn['checkin_by'] = $this->checkin_by ?? null;
            }

            if ($this->pivot->verified) {
                $rtn['verified'] = $this->pivot->verified ?? false;
                $rtn['verified_by'] = $this->verified_by ?? null;
            }

            $rtn['hours'] = (float)$this->shifts->reduce(function($carry, $item) {
                $date1 = new \DateTime($item->start_time);
                $date2 = new \DateTime($item->end_time);

                $diff = $date2->diff($date1);

                $hours = $diff->h;
                $hours = $hours + ($diff->days*24);
                return $carry + $hours;
            }, 0);

            $rtn['claimed'] = (bool)$this->password;

            $rtn['claim_code'] = (string)$this->claim_code;
        }

        // $this->mergeAdditionalFields($request, $rtn, 'users');

        $rtn = array_merge($rtn, [
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ]);

        return $rtn;
    }
}

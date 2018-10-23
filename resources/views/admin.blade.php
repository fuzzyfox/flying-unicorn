@extends('layouts.app')

@section('content')
<fu-view-admin inline-template>
    <div class="admin">
        <b-row class="mb-3">
            <b-col cols="8">
                <b-card title="Schedule">
                    <fu-calednar
                        :events="events"
                        @event-click="onEventClick"
                    ></fu-calednar>
                    {{-- <code>{{ url('') }}/calendar/{{ Auth::user()->id }}.ics</code> --}}
                </b-card>
            </b-col>
            <b-col cols="4">
                <b-card title="Users" class="mb-1">
                    <table class="table table-stripped" style="max-height: 80%;overflow: auto;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="user in users"
                                :class="{active:user.id == activeUserId, highlight: activeShift && activeShift.users.find(u=>u.id === user.id)}"
                                @click="onUserClick(user)"
                            >
                                <td>@{{user.name}}</td>
                                <td>@{{user.hours}}</td>
                            </tr>
                        </tbody>
                    </table>
                </b-card>

                <b-card v-if="activeUser" :title="activeUser.name" class="mb-1">
                    <div><small>Tito Ticket Id: <code>@{{user.claim_code}}</code></small></div>
                    <b-badge v-for="team in activeUser.teams" :key="team.id" variant="primary">@{{team.name}}</b-badge>
                </b-card>

                <b-card v-if="activeShift && activeUserId" :title="activeShift.name">
                    <p v-if="activeShift.description">@{{activeShift.description}}</p>
                    <p v-if="activeShift.location">📍 <em>@{{activeShift.location.name}}</em></p>

                    <b-btn
                        v-if="activeShift.users.find(u => u.id === activeUserId)"
                        variant="danger"
                        @click="removeCurrentFromShift"
                    >Remove from shift</b-btn>
                    <b-btn
                        v-else
                        variant="primary"
                        @click="addCurrentToShift"
                    >Add to shift</b-btn>
                </b-card>
            </b-col>
        </b-row>
    </div>
</fu-view-admin>
@endsection

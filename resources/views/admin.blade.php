@extends('layouts.app')

@section('content')
<fu-view-admin inline-template>
    <div class="admin">
        <b-row class="mb-3">
            <b-col cols="8">
                <b-card title="Schedule">
                    <fu-calednar
                        :config="calendarConfig"
                        :events="events"
                        @event-click="onEventClick"
                    ></fu-calednar>
                    {{-- <code>{{ url('') }}/calendar/{{ Auth::user()->id }}.ics</code> --}}
                </b-card>
            </b-col>

            <b-col cols="4">
                <b-card title="Teams" class="mb-1">
                    <b-badge variant="danger" @click="currentTeamId = null">none</b-badge>
                    <b-badge v-for="team in teams" :key="team.id" variant="primary" @click="currentTeamId = team.id">@{{team.name}}</b-badge>
                </b-card>

                <b-card title="Users" class="mb-1" style="max-height: 50vh;overflow: auto;">
                    <b-form-checkbox v-model="showUnclaimed">
                        Show Unclaimed
                    </b-form-checkbox>
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>hours</th>
                                <th>claim code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="user in users"
                                :class="{active:user.id == activeUserId, highlight: activeShift && activeShift.users.find(u=>u.id === user.id), claimed: user.claimed}"
                                @click="onUserClick(user)"
                            >
                                <td>@{{user.name}}</td>
                                <td>@{{user.hours}}</td>
                                <td>@{{user.claim_code}}</td>
                            </tr>
                        </tbody>
                    </table>
                </b-card>

                <b-card v-if="activeUser" :title="activeUser.name" class="mb-1">
                    <div>
                        <strong><small>Hours: <code>@{{activeUser.hours}}</code></small></strong><br>
                        <small>Tito Ticket Id: <code>@{{activeUser.claim_code}}</code></small>
                    </div>
                    <b-badge v-for="team in activeUser.teams" :key="team.id" variant="primary">@{{team.name}}</b-badge>
                </b-card>

                <b-card v-if="activeShift" :title="activeShift.name">
                    <p v-if="activeShift.description">@{{activeShift.description}}</p>
                    <ul>
                        <li v-if="activeShift.user">👤 <em>@{{activeShift.user.name}}</em></li>
                        <li v-if="activeShift.location">📍 <em>@{{activeShift.location.name}}</em></li>
                        <li v-if="activeShift.min">min: @{{activeShift.min}}</li>
                        <li v-if="activeShift.max">max: @{{activeShift.max}}</li>
                        <li v-if="activeShift.desired">desired: @{{activeShift.desired}}</li>
                        <li v-if="activeShift.users">count: @{{activeShift.users.length}}</li>
                    </ul>

                    <template v-if="activeUserId">
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
                    </template>

                    <hr>

                    <ul>
                        <li v-for="user in activeShift.users" @click="onUserClick(user)">@{{user.name}}</li>
                    </ul>

                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Check-in</th>
                                <th>Verify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="user in activeShift.users"
                                class="claimed"
                            >
                                <td @click="onUserClick(user)">@{{user.name}}</td>
                                <td>
                                    <b-badge v-if="user.checkin">@{{user.checkin}}</b-badge>
                                    <b-btn v-if="!user.checkin" @click="checkinUser(user)">checkin</b-btn>
                                </td>
                                <td>
                                    <b-badge v-if="user.verfied">@{{user.verfied}}</b-badge>
                                    <b-btn v-if="!user.verfied" @click="verifyUser(user)">verify</b-btn>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </b-card>
            </b-col>
        </b-row>
    </div>
</fu-view-admin>
@endsection

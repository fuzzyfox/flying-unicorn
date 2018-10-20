@extends('layouts.app')

@section('content')
<fu-view-home inline-template>
    <b-container>
        <b-row class="mb-3">
            <b-col cols="12">
                <b-card title="Schedule">
                    <fu-calednar :events="events"></fu-calednar>
                    {{-- <code>{{ url('') }}/calendar/{{ Auth::user()->id }}.ics</code> --}}
                </b-card>
            </b-col>
        </b-row>
        <b-row>
            <b-col cols=12>
                <b-card title="Teams" class="mb-3">
                    <b-alert :show="!user.teams.length">
                        You've not joined any teams yet.
                        <a href="{{ route('teams.view') }}" class="alert-link">Join one now!</a>.
                    </b-alert>

                    <table class="table table-stipped" v-if="user.teams.length">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="team in user.teams">
                                <th scope="row">@{{team.name}}</th>
                                <td>@{{team.status}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <b-link href="{{ route('teams.view') }}" class="card-link">View Teams</b-link>
                </b-card>
            </b-col cols=4>
        </b-row>
    </b-container>
</fu-view-home>
@endsection

@extends('layouts.app')

@section('content')
<fu-view-teams inline-template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <b-card
                    v-for="team in teams"
                    :key="team.id"
                    :title="team.name"
                    :sub-title="team.user ? 'Team Lead: ' + team.user.name : ''"
                    class="mb-3"
                >
                    <p class="card-text">
                        @{{ team.description }}
                    </p>
                    <b-btn v-if="canJoinTeam(team)" @click.prevent="joinTeam(team)" variant="primary">Join Team</b-btn>
                    <b-badge v-if="getUserTeamObj(team) && getUserTeamObj.status == 'pending'" variant="secondary">Pending</b-badge>
                    <b-btn v-if="canLeaveTeam(team)" @click.prevent="leaveTeam(team)" variant="danger">Leave Team</b-btn>
                    <b-badge v-if="team.restricted">restricted</b-badge>
                    <b-badge v-if="team.user_id === user.id" variant="success">team lead</b-badge>
                </b-card>
            </div>
        </div>
    </div>
</fu-view-teams>
@endsection

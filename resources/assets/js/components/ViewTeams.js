import {mapState, mapGetters} from 'vuex'

import * as TeamService from '@/http/TeamService'

export default {
    name: 'fu-view-teams',

    data() {
        return {}
    },

    computed: {
        ...mapState(['user']),
        ...mapGetters({teams: 'teamsAsArray'})
    },

    methods: {
        joinTeam(team) {
            return TeamService.storeMember(team.id, this.user.id)
                .then(({data}) => {
                    return this.$store.dispatch('fetchUser', { id: this.user.id })
                })
        },
        leaveTeam(team) {
            return TeamService.destroyMember(team.id, this.user.id)
                .then(({data}) => {
                    return this.$store.dispatch('fetchUser', { id: this.user.id })
                })
        },
        canJoinTeam(team) {
            return !team.restricted && !this.user.teams.find(({id}) => id === team.id)
        },
        canLeaveTeam(team) {
            return this.user.teams.find(({id}) => id === team.id)
        },
        getUserTeamObj(team) {
            return this.user.teams.find(({id}) => id === team.id)
        }
    }
}

import {mapState, mapGetters} from 'vuex'

export default {
    name: 'fu-view-home',

    data() {
        return {

        }
    },

    computed: {
        ...mapState(['user']),
        ...mapGetters({teams: 'teamsAsArray'}),
        events() {
            const dnds = this.user.dnds.map(e => ({
                start: e.start_time,
                end: e.end_time,
                title: e.reason || 'Do Not Disturb',
                color: 'tomato'
            }))

            const shifts = this.user.shifts.map(e => ({
                start: e.start_time,
                end: e.end_time,
                title: e.name || undefined,
                description: e.description || undefined,
                location: e.location ? {...e.location} : undefined,
                user: e.user ? {...e.user} : undefined
            }))
            return [...dnds, ...shifts]
        }
    },
}

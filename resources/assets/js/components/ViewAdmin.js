import {mapState, mapGetters} from 'vuex'
import sortBy from 'lodash/sortBy'

import * as ShiftService from '@/http/ShiftService'

export default {
    name: 'fu-view-admin',

    data() {
        return {
            activeUserId: null,
            activeShift: null,
            currentTeamId: null
        }
    },

    computed: {
        ...mapState(['user']),
        ...mapGetters({shifts: 'shiftsAsArray'}),
        ...mapGetters({teams: 'teamsAsArray'}),
        users() {
            let list = sortBy(this.$store.getters.usersAsArray, 'hours');

            if (this.currentTeamId) {
                list = list.filter(u=>u.teams.find(t => t.id === this.currentTeamId))
            }
            return list
        },
        dnds() {
            return this.activeUser ? this.activeUser.dnds.map( dnd => ({
                start: dnd.start_time,
                end: dnd.end_time,
                color: 'tomato',
                title: dnd.reason || undefined,
                selectable: false,
                editable: false,
            })) : []
        },
        events() {
            const shifts = this.shifts.map(e => ({
                id: e.id,
                start: e.start_time,
                end: e.end_time,
                title: e.name || undefined,
                description: e.description || undefined,
                location: e.location ? {...e.location} : undefined,
                user: e.user ? {...e.user} : undefined,
                min: e.min,
                max: e.max,
                desired: e.desired,
                users: e.users || undefined,
                color: e.users
                    ? e.users.find(u=>u.id === this.activeUserId)
                        ? '#ffc107'
                        : e.users.length >= e.desired
                            ? '#28a745'
                            : e.users.length > e.min
                                ? '#17a2b8'
                                : '#6c757d'
                    : '#ff8000'
            }))

            return [...shifts, ...this.dnds]
        },
        activeUser() {
            return this.users.find(u => u.id === this.activeUserId)
        }
    },

    methods: {
        onUserClick(user) {
            this.activeUserId = user.id
            this.activeShift = null
        },
        onEventClick(info) {
            this.activeShift = this.$store.state.shifts[info.event.id]
        },
        addCurrentToShift() {
            return ShiftService.storeUser(this.activeShift.id, this.activeUserId)
                .then(() => this.$store.dispatch('fetchUsers'))
                .then(() => this.$store.dispatch('fetchShifts'))
                .then(() => {
                    const id = this.activeShift.id
                    this.activeShift = null
                    return this.$nextTick(() => {
                        this.activeShift = this.$store.state.shifts[id]
                    })
                })
        },
        removeCurrentFromShift() {
            return ShiftService.destroyUser(this.activeShift.id, this.activeUserId)
                .then(() => this.$store.dispatch('fetchUsers'))
                .then(() => this.$store.dispatch('fetchShifts'))
                .then(() => {
                    const id = this.activeShift.id
                    this.activeShift = null
                    return this.$nextTick(() => {
                        this.activeShift = this.$store.state.shifts[id]
                    })
                })
        }
    }
}

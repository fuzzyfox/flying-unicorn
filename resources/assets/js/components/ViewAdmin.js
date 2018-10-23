import {mapState, mapGetters} from 'vuex'

import * as ShiftService from '@/http/ShiftService'

export default {
    name: 'fu-view-admin',

    data() {
        return {
            activeUserId: null,
            activeShift: null
        }
    },

    computed: {
        ...mapState(['user']),
        ...mapGetters({users: 'usersAsArray'}),
        ...mapGetters({shifts: 'shiftsAsArray'}),
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
            }))

            return [...shifts, ...this.dnds]
        },
        activeUser() {
            return this.users.find(u => u.id === this.activeUserId)
        }
    },

    watch: {
        activeUserId(val, prev) {
            if (!val || val !== prev) {
                this.activeShift = null
            }
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

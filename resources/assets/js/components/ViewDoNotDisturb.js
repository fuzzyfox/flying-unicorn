import {mapState, mapGetters} from 'vuex'
import moment from 'moment'

import * as DoNotDisturbService from '@/http/DoNotDisturbService'

export default {
    name: 'fu-view-donotdisturb',

    data() {
        return {
            calendarConfig: {
                defaultView: 'agendaWeek',
                allDaySlot: false,
                scrollTime: '07:00:00',
                nowIndicator: true,
                firstDay: 1,
                validRange: {
                    start: process.env.MIX_EVENT_START,
                    end: process.env.MIX_EVENT_END
                },
                selectable: true,
            },
            newEvent: null,
            selectedEvent: null
        }
    },

    computed: {
        ...mapState(['user']),
        dnds() {
            return this.user.dnds.map(dnd => ({
                start: dnd.start_time,
                end: dnd.end_time,
                color: 'tomato',
                id: dnd.id,
                title: dnd.reason || undefined,
                selectable: true
            }))
        },
        events() {
            return this.newEvent ? [this.newEvent, ...this.dnds] : this.dnds
        }
    },

    watch: {
        newEvent(val) {
            if (val) {
                this.selectedEvent = null
            }
        },
        selectedEvent(val) {
            if (val) {
                this.newEvent = null
            }
        }
    },

    methods: {
        onSubmit() {
            const event = this.newEvent || this.selectedEvent
            const method = event.id ? 'update' : 'store'

            return DoNotDisturbService[method]({
                start_time: moment(event.start).format('YYYY-MM-DD HH:mm:ss'),
                end_time: moment(event.end).format('YYYY-MM-DD HH:mm:ss'),
                reason: event.title || null,
                id: event.id || null
            }).then(({data}) => {
                this.onReset()
                return this.$store.dispatch('fetchUser', {id: this.user.id})
            })
        },
        onReset() {
            this.newEvent = null
            this.selectedEvent = null
        },

        onSelect(info) {
            this.newEvent = {
                start: moment(info.startStr).format('YYYY-MM-DD HH:mm:ss'),
                end: moment(info.endStr).format('YYYY-MM-DD HH:mm:ss'),
                title: ''
            }
        },
        onUnselect(info) {},

        onEventClick(event) {
            this.selectedEvent = {
                start: moment(event.event.start).format('YYYY-MM-DD HH:mm:ss'),
                end: moment(event.event.end).format('YYYY-MM-DD HH:mm:ss'),
                title: event.event.title,
                id: event.event.id,
            }
        },

        onDelete() {
            return DoNotDisturbService.destroy(this.selectedEvent.id)
                .then(() => {
                    this.onReset()
                    return this.$store.dispatch('fetchUser', {id: this.user.id})
                })
        },
    }
}

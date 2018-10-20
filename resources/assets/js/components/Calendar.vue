<template lang="html">
    <div class="fu-calednar"></div>
</template>

<script>
    import { Calendar } from 'fullcalendar';
    import moment from 'moment'

    export default {
        name: 'fu-calednar',

        props: {
            config: {
                type: Object,
                default() {
                    return {
                        defaultView: 'agendaWeek',
                        allDaySlot: false,
                        scrollTime: '07:00:00',
                        nowIndicator: true,
                        firstDay: 1,
                        validRange: {
                            start: process.env.MIX_EVENT_START,
                            end: process.env.MIX_EVENT_END
                        }
                    }
                }
            },

            events: {
                type: Array,
                default() {
                    return []
                }
            }
        },

        data() {
            return {
                calendar: null
            }
        },

        watch: {
          events(value) {
              this.calendar.getEventSources().forEach(eventSource => {
                  eventSource.remove()
              })
              this.calendar.addEventSource(value)
          }
        },

        mounted() {
            this.calendar = new Calendar(this.$el, {
                ...this.config,
                select: this.onSelect,
                unselect: this.onUnselect,
                eventClick: this.onEventClick,
                events: this.events
            })
            this.calendar.render();
        },

        methods: {
          onSelect(...args) { this.$emit('select', ...args) },
          onUnselect(...args) { this.$emit('unselect', ...args) },
          onEventClick(...args) { this.$emit('event-click', ...args) },
        }
    }

</script>

<style lang="scss">
</style>

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
                header: { center: 'month,agendaWeek,agendaDay' },
                select: this.onSelect,
                unselect: this.onUnselect,
                eventClick: this.onEventClick,
                events: this.events,
                eventRender(info) {
                    const contentEl = info.el.querySelector('.fc-content')
                    const {description, location, user, min, max, desired, users} = info.event.extendedProps

                    if (user) {
                        const userEl = document.createElement('div')
                        userEl.classList.add('fc-user')
                        userEl.textContent = user.name
                        contentEl.appendChild(userEl)
                    }

                    if (description) {
                        const descEl = document.createElement('div')
                        descEl.classList.add('fc-description')
                        descEl.textContent = description
                        contentEl.appendChild(descEl)
                    }

                    if (location) {
                        const locEl = document.createElement('div')
                        locEl.classList.add('fc-location')
                        locEl.textContent = location.name
                        contentEl.appendChild(locEl)
                    }

                    if (min) {
                        const descEl = document.createElement('div')
                        descEl.classList.add('fc-min')
                        descEl.textContent = `min: ${min}`
                        contentEl.appendChild(descEl)
                    }

                    if (max) {
                        const descEl = document.createElement('div')
                        descEl.classList.add('fc-max')
                        descEl.textContent = `max: ${max}`
                        contentEl.appendChild(descEl)
                    }

                    if (desired) {
                        const descEl = document.createElement('div')
                        descEl.classList.add('fc-desired')
                        descEl.textContent = `desired: ${desired}`
                        contentEl.appendChild(descEl)
                    }

                    if (users && Array.isArray(users)) {
                        const descEl = document.createElement('div')
                        descEl.style.fontWeight = 'bold'
                        descEl.classList.add('fc-desired')
                        descEl.textContent = `count: ${users.length}`
                        contentEl.appendChild(descEl)
                    }
                }
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

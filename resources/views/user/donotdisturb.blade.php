@extends('layouts.app')

@section('content')
<fu-view-donotdisturb inline-template>
    <b-container fluid>
        <b-row>
            <b-col cols="8">
                <b-card title="Do Not Disturb Times">
                    <fu-calednar
                        :config="calendarConfig"
                        :events="events"
                        @select="onSelect"
                        @unselect="onUnselect"
                        @event-click="onEventClick"
                    ></fu-calednar>
                </b-card>
            </b-col>
            <b-col cols=4>
                <b-card title="New Event" class="mb-3" v-if="newEvent">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-form-group
                            label="Start Time:"
                            label-for="new-event__start-time"
                        >
                            <b-form-input
                                id="new-event__start-time"
                                type="text"
                                v-model="newEvent.start"
                                disabled
                            >
                            </b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="End Time:"
                            label-for="new-event__end-time"
                        >
                            <b-form-input
                                id="new-event__end-time"
                                type="text"
                                v-model="newEvent.end"
                                disabled
                            >
                            </b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Reason:"
                            label-for="new-event__start-time"
                            description="Optional short description of why not to disturb"
                        >
                            <b-form-input
                                id="new-event__start-time"
                                type="text"
                                v-model="newEvent.title"
                            >
                            </b-form-input>
                        </b-form-group>

                        <b-button type="submit" variant="primary">Add</b-button>
                        <b-button type="reset" variant="secondary">Cancel</b-button>
                    </b-form>
                </b-card>

                <b-card title="Update Event" class="mb-3" v-if="selectedEvent">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-form-group
                            label="Start Time:"
                            label-for="new-event__start-time"
                        >
                            <b-form-input
                                id="new-event__start-time"
                                type="text"
                                v-model="selectedEvent.start"
                                disabled
                            >
                            </b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="End Time:"
                            label-for="new-event__end-time"
                        >
                            <b-form-input
                                id="new-event__end-time"
                                type="text"
                                v-model="selectedEvent.end"
                                disabled
                            >
                            </b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Reason:"
                            label-for="new-event__start-time"
                            description="Optional short description of why not to disturb"
                        >
                            <b-form-input
                                id="new-event__start-time"
                                type="text"
                                v-model="selectedEvent.title"
                            >
                            </b-form-input>
                        </b-form-group>

                        <b-button type="submit" variant="primary">Update</b-button>
                        <b-button type="reset" variant="secondary">Cancel</b-button>
                        <b-button type="button" variant="danger" @click="onDelete(this.selectedEvent)">Delete</b-button>
                    </b-form>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</fu-view-donotdisturb>
@endsection

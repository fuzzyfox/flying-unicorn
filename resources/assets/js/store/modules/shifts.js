import * as ShiftService from '@/http/ShiftService'

export const initState = () => ({})

export const state = initState()

export const getters = {
    shiftsAsArray(state) {
        return Object.values(state)
    }
}

export const mutations = {
    addShift(state, shift) {
        Vue.set(state, shift.id, shift)
    },
    addShifts(state, shifts = []) {
        shifts.forEach(shift => mutations.addShift(state, shift));
    }
}

export const actions = {
    init({dispatch}) {
        return Promise.all([
            dispatch('fetchShifts')
        ])
    },
    fetchShifts({commit}) {
        return ShiftService.index()
            .then(({data}) => {
                commit('addShifts', data.data)
            })
    },
    fetchShift({commit}, {id}) {
        return ShiftService.show(id)
            .then(({data}) => {
                commit('addShift', data.data)
            })
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}

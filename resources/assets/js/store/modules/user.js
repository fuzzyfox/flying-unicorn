import * as UserService from '@/http/UserService'

export const initState = () => ({
    id: null,
    teams: [],
    dnds: [],
    shifts: [],
})

export const state = initState()

export const getters = {}

export const mutations = {
    setUser(state, { id, teams = [], dnds = [], shifts = [] }) {
        state.id = id
        state.teams = teams || []
        state.dnds = dnds || []
        state.shifts = shifts || []
    },
    setUserTeam(state, team) {
        if (!state.teams.find(({id}) => id === team.id)) {
            state.teams.push(team)
        }
    }
}

export const actions = {
    init({dispatch}) {
        return Promise.all([
            dispatch('fetchUser', {id: 'me'})
        ])
    },
    fetchUser({commit}, { id }) {
        return UserService.show(id)
            .then(({data}) => {
                commit('setUser', data.data)
            })
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}

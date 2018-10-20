import * as TeamService from '@/http/TeamService'

export const initState = () => ({})

export const state = initState()

export const getters = {
    teamsAsArray(state) {
        return Object.values(state)
    }
}

export const mutations = {
    addTeam(state, team) {
        Vue.set(state, team.id, team)
    },
    addTeams(state, teams = []) {
        teams.forEach(team => mutations.addTeam(state, team));
    }
}

export const actions = {
    init({dispatch}) {
        return Promise.all([
            dispatch('fetchTeams')
        ])
    },
    fetchTeams({commit}) {
        return TeamService.index()
            .then(({data}) => {
                commit('addTeams', data.data)
            })
    },
    fetchTeam({commit}, {id}) {
        return TeamService.show(id)
            .then(({data}) => {
                commit('addTeam', data.data)
            })
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}

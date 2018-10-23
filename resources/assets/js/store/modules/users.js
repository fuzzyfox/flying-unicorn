import * as UserService from '@/http/UserService'

export const initState = () => ({})

export const state = initState()

export const getters = {
    usersAsArray(state) {
        return Object.values(state)
    }
}

export const mutations = {
    addUser(state, user) {
        Vue.set(state, user.id, user)
    },
    addUsers(state, users = []) {
        users.forEach(user => mutations.addUser(state, user));
    }
}

export const actions = {
    init({dispatch}) {
        return Promise.all([
            dispatch('fetchUsers')
        ])
    },
    fetchUsers({commit}) {
        return UserService.index()
            .then(({data}) => {
                commit('addUsers', data.data)
            })
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}

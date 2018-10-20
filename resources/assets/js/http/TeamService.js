export const root = '/api/teams';

export const index = (params) => axios.get(`${root}`, {params})
export const store = (teamId, userObj) => axios.post(`${root}`, userObj)
export const show = (teamId, params) => axios.get(`${root}/${teamId}`, { params })
export const update = (teamId, userObj) => axios.put(`${root}/${teamId}`, userObj)
export const destroy = (teamId) => axios.delete(`${root}/${teamId}`, userObj)

export const storeMember = (teamId, userId) => axios.post(`${root}/${teamId}/members`, {user_id: userId})
export const destroyMember = (teamId, userId) => axios.delete(`${root}/${teamId}/members/${userId}`)

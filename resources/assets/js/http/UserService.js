export const root = '/api/users';

export const index = (params) => axios.get(`${root}`, {params})
export const show = (userId, params) => axios.get(`${root}/${userId}`, { params })
export const update = (userId, userObj) => axios.put(`${root}/${userId}`, userObj)
export const destroy = (userId) => axios.delete(`${root}/${userId}`, userObj)

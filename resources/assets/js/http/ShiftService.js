export const root = '/api/shifts';

export const index = (params) => axios.get(`${root}`, {params})
export const store = (shiftId, userObj) => axios.post(`${root}`, userObj)
export const show = (shiftId, params) => axios.get(`${root}/${shiftId}`, { params })
export const update = (shiftId, userObj) => axios.put(`${root}/${shiftId}`, userObj)
export const destroy = (shiftId) => axios.delete(`${root}/${shiftId}`, userObj)

export const storeUser = (shiftId, userId) => axios.post(`${root}/${shiftId}/users`, {user_id: userId})
export const checkinUser = (shiftId, userId) => axios.post(`${root}/${shiftId}/checkin`, {user_id: userId})
export const verifyUser = (shiftId, userId) => axios.post(`${root}/${shiftId}/verify`, {user_id: userId})
export const destroyUser = (shiftId, userId) => axios.delete(`${root}/${shiftId}/users/${userId}`)

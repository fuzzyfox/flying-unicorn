export const root = '/api/donotdisturbs';

export const index = (params) => axios.get(`${root}`, {params})
export const store = (dndObj) => axios.post(`${root}`, dndObj)
export const show = (dndId, params) => axios.get(`${root}/${dndId}`, { params })
export const update = (dndId, userObj) => axios.put(`${root}/${dndId}`, userObj)
export const destroy = (dndId) => axios.delete(`${root}/${dndId}`)

export const state = () => ({
    users: [], //DATA USER AKAN DISIMPAN KE DALAM STATE INI
    errors: []
})

export const mutations = {
    //MUTATION INI DIGUNAKAN UNTUK MENGUBAH VALUE DARI STATE USERS
    SET_USER_DATA(state, payload) {
        state.users = payload
    },
    SET_ERRORS(state, payload) {
        state.errors = payload
    }
}

export const actions = {
    //FUNGSI UNTUK MENGAMBIL DATA USER
    getUsersData({ commit }) {
        return new Promise((resolve, reject) => {
            //DIMANA KITA MELAKUKAN REQUEST DENGAN METHOD GET KE URL /USERS
            this.$axios.get('/users').then((response) => {
                //DAN MENYIMPAN DATANYA KE STATE USERS MELALUI MUTATIONS
                commit('SET_USER_DATA', response.data.data)
                resolve()
            })
        })
    },

    storeUsersData({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            //MENGIRIM REQUEST KE SERVER DENGAN METHOD POST DAN DATA DARI PAYLOAD
            this.$axios.post('/users', payload)
                .then(() => {
                    //JIKA BERHASIL, MAKA LOAD DATA TERBARU
                    dispatch('getUsersData')
                    resolve()
                })
                .catch((error) => {
                    //JIKA TERJADI ERROR VALIDASI, SET STATE UNTUK MENAMPUNG DATA ERROR VALIDASINYA
                    commit('SET_ERRORS', error.response.data)
                })
        })
    },
}

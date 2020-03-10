import moment from 'moment';

class User {
    constructor (name, email, email_verified_at = null, password = null, id = null) {
        this.name = name;
        this.email = email;
        this.email_verified_at = email_verified_at;
        this.password = password;
        this.id = id;
    }
}

export default {
    state: {
        users: []
    },
    mutations: {
        loadUsers (state, payload) {
            state.users = payload
        },
        createUser (state, payload) {
            state.users.push(payload)
        },
        deleteUser (state, payload) {
            let user = state.users.findIndex(us => us.id === payload);
            state.users.splice(user, 1);
        },
        updateUser (state, {name, email, password, id}) {
            const user = state.users.find(us => {
                return us.id === id
            });
            user.name = name;
            user.email = email;
            user.password = password;
        }
    },
    actions: {
        async fetchUsers ({commit}) {
            commit('clearError');
            commit('setLoading', true);
            const resultUser = [];

            await axios.get('/api/user').then((response) => {
                const users = response.data.users;

                if (users.length !== 0) {
                    Object.keys(users).forEach(key => {
                        const user = users[key];
                        resultUser.push(
                            new User(user.name, user.email, moment(user.email_verified_at).format('DD.MM.YYYY HH:mm'), '', user.id)
                        )
                    })
                }

                commit('loadUsers', resultUser);
                commit('setLoading', false)
            }).catch(error => {
                commit('setError', error.message);
                commit('setLoading', false);
                throw error
            });
        },
        async createUser ({commit, getters}, payload) {
            commit('clearError');
            commit('setLoading', true);

            let formData = new FormData();
            formData.append('name', payload.name);
            formData.append('email', payload.email);
            formData.append('password', payload.password);

            await axios.post('/api/user', formData).then((response) => {
                const newUser = new User(response.data.new_user.name, response.data.new_user.email,
                    response.data.new_user.email_verified_at, response.data.new_user.password, response.data.new_user.id);

                commit('createUser', {
                    ...newUser,
                });
                commit('setLoading', false)
            }).catch(error => {
                commit('setError', error.message);
                commit('setLoading', false);
                throw error
            });
        },
        async deleteUser ({commit, getters}, payload) {
            commit('clearError');
            commit('setLoading', true);

            await axios.delete('/api/user/' + payload).then((response) => {
                if (response.user === 1) {
                    commit('deleteUser', payload);
                }

                commit('setLoading', false);
            }).catch(error => {
                commit('setError', error.message);
                commit('setLoading', false);
                throw error;
            });
        },
        async updateUser ({commit, getters}, payload) {
            commit('clearError');
            commit('setLoading', true);

            let formData = new FormData();
            formData.append('name', payload.name);
            formData.append('email', payload.email);
            formData.append('password', payload.password);
            formData.append('_method', 'PUT');

            await axios.post('/api/user/' + payload.id, formData).then((response) => {
                commit('updateUser', {
                    name: response.data.update_user.name,
                    email: response.data.update_user.email,
                    password: response.data.update_user.password,
                    id: response.data.update_user.id,
                });

                commit('setLoading', false)
            }).catch(error => {
                commit('setError', error.message);
                commit('setLoading', false);
                throw error
            });
        },
    },
    getters: {
        users (state) {
            return state.users;
        },
    }
}

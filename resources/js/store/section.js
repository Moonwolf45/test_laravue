class Section {
    constructor (name, description = '', logo = '', users = [], id = null) {
        this.name = name;
        this.description = description;
        this.logo = logo;
        this.users = users;
        this.id = id;
    }
}

export default {
    state: {
        sections: []
    },
    mutations: {
        createSection (state, payload) {
            state.sections.push(payload)
        },
        loadSections (state, payload) {
            state.sections = payload
        },
        deleteSections (state, payload) {
            let section = state.sections.findIndex(sec => sec.id === payload);
            state.sections.splice(section, 1);
        },
        updateSection (state, {name, description, logo, users, id}) {
            const section = state.sections.find(sec => {
                return sec.id === id
            });
            section.name = name;
            section.description = description;
            section.logo = logo;
            section.users = users;
        }
    },
    actions: {
        async fetchSections ({commit}) {
            commit('clearError');
            commit('setLoading', true);
            const resultSection = [];

            await axios.get('/api/section').then((response) => {
                const sections = response.data.sections;

                if (sections.length !== 0) {
                    Object.keys(sections).forEach(key => {
                        const section = sections[key];
                        resultSection.push(
                            new Section(section.name, section.description, section.logo, section.users, section.id)
                        )
                    })
                }

                commit('loadSections', resultSection);
                commit('setLoading', false)
            }).catch(error => {
                commit('setError', error.message);
                commit('setLoading', false);
                throw error
            });
        },
        async createSection ({commit, getters}, payload) {
            commit('clearError');
            commit('setLoading', true);

            let formData = new FormData();
            formData.append('name', payload.name);
            formData.append('description', payload.description);
            formData.append('image', payload.image);
            formData.append('users', payload.users);

            await axios.post('/api/section', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                const newSection = new Section(
                    response.data.new_section.name,
                    response.data.new_section.description,
                    response.data.new_section.logo,
                    response.data.new_section.users,
                    response.data.new_section.id
                );

                commit('createSection', {
                    ...newSection,
                });
                commit('setLoading', false)
            }).catch(error => {
                commit('setError', error.message);
                commit('setLoading', false);
                throw error
            });
        },
        async deleteSection ({commit, getters}, payload) {
            commit('clearError');
            commit('setLoading', true);

            await axios.delete('/api/section/' + payload).then((response) => {
                if (response.status === 1) {
                    commit('deleteSections', payload);
                }

                commit('setLoading', false);
            }).catch(error => {
                commit('setError', error.message);
                commit('setLoading', false);
                throw error;
            });
        },
        async updateSection ({commit, getters}, payload) {
            commit('clearError');
            commit('setLoading', true);

            let formData = new FormData();
            formData.append('name', payload.name);
            formData.append('description', payload.description);
            formData.append('image', payload.image);
            formData.append('users', payload.users);
            formData.append('_method', 'PUT');

            await axios.post('/api/section/' + payload.id, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                commit('updateSection', {
                    name: response.data.update_section.name,
                    description: response.data.update_section.description,
                    logo: response.data.update_section.logo,
                    users: response.data.update_section.users,
                    id: response.data.update_section.id,
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
        sections (state) {
            return state.sections;
        }
    }
}

import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        deleteObj: {
            showDeleteModal: false,
            deleteUrl: "",
            data: null,
            deletingIndex: -1,
            isDeleted: false,
        },
    },
    mutations: {
        setDeleteModalObj(state, data) {
            state.deleteObj = data;
        },
        setDeleteModal(state, data) {
            const deleteModalObj = {
                showDeleteModal: false,
                deleteUrl: "",
                data: null,
                deletingIndex: -1,
                isDeleted: data,
            };
            state.deleteObj = deleteModalObj;
        },
    },
    getters: {
        getDeleteModalObj(state) {
            return state.deleteObj;
        },
    },
    actions: {},

    modules: {},
});

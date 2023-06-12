import {headers, notificationMessages} from "@/utils";
import axios from "axios";

export const state = {
    user: null,
    bookedSlots:[],
    formPortalActivated: false,
    formPortalLocation: '',
    notification: '',
    loading: false,
    askConfirmation: false,
    confirmationMessage: '',
    chosenDateTime:'',
    vehicleMake:'',
    vehicleModel:'',
    blockedDayAndTimes:[]
}
export const getters = {
    bookedSlots(state){
        return state.bookedSlots;
    },
    user(state) {
        return state.user;
    },
    formPortalActivated(state) {
        return state.formPortalActivated;
    },
    formPortalLocation(state) {
        return state.formPortalLocation;
    },
    isRegistration(state) {
        return state.formPortalLocation === 'reg';
    },
    notification(state) {
        return state.notification;
    },
    loading(state) {
        return state.loading;
    },
    askConfirmation(state) {
        return state.askConfirmation;
    },
    confirmationMessage(state) {
        return state.notificationMessage;
    },
    chosenDateTime(state) {
        return state.chosenDateTime;
    }
}
export const mutations = {
    setBookedSlots(state, bookedSlots){
        state.bookedSlots = bookedSlots;
    },
    setUser(state, user) {
        state.user = user;
    },
    setFormPortalActivated(state, formPortalActivated) {
        state.formPortalLocation = formPortalActivated;
        state.formPortalActivated = !!formPortalActivated;

    },
    setNotification(state, notification) {
        state.notification = notification;
    },
    setLoading(state, loading) {
        state.loading = loading;
    },
    setAskConfirmation(state, askConfirmation) {
        state.askConfirmation = askConfirmation;
    },
    setConfirmationMessage(state, notificationMessage) {
        state.notificationMessage = notificationMessage;
    },
    setChosenDateTime(state, chosenDateTime) {
        state.chosenDateTime = chosenDateTime;
    },
    setVehicleMake(state, vehicleMake) {
        state.vehicleMake = vehicleMake;
    },
    setVehicleModel(state, vehicleModel) {
        state.vehicleModel = vehicleModel;
    }
}


export const actions = {

    //get all booked slots
    getBookedSlots({commit}){
        commit('setLoading', true);
        axios.get(`${process.env.VUE_APP_API_URL}/bookings`).then((response) => {
            commit('setBookedSlots', response.data.data);
            commit('setAskConfirmation', false);
            commit('setLoading', false);
        }).catch(() => {
            commit('setLoading', false);
        });
    },
    logUserOut({commit}) {
        commit('setLoading', true);
        localStorage.removeItem('user');
        commit('setUser', null);
        commit('setNotification', notificationMessages["logged-out"]);
        commit('setLoading', false);
        axios.get(`${process.env.VUE_APP_API_URL}/auth/logout`, headers()).catch(() => {});
        localStorage.removeItem('booking_token');
    },

    //register or log in a user
    registerLogInUser({commit, state}, details) {
        commit('setLoading', true);
        const location = state.formPortalLocation === 'reg' ? `${process.env.VUE_APP_API_URL}/auth/register` : `${process.env.VUE_APP_API_URL}/auth/login`;
        axios.post(location, details)
            .then((response) => {
                localStorage.setItem('booking_token', response.data.token);
                localStorage.setItem('user', JSON.stringify(response.data.data));
                commit('setUser', response.data.data);
                commit('setFormPortalActivated', '')
                commit('setLoading', false);
                commit('setNotification', notificationMessages["logged-in"]);
            })
            .catch(() => {
                localStorage.removeItem('booking_token');
                localStorage.removeItem('user');
                commit('setLoading', false);
            });
    },

    //get the logged in user details
    loggedInUser({commit}) {
        commit('setLoading', true);
        axios.get(`${process.env.VUE_APP_API_URL}/auth/user`,headers()).then((response) => {
            if(!response.data.data) {
                localStorage.removeItem('booking_token');
                localStorage.removeItem('user');
            }
            commit('setUser', response.data.data ? response.data.data : null);
            commit('setLoading', false);
            !response.data.data ? commit('setNotification', notificationMessages["login-prompt"]) : commit('setNotification', notificationMessages["logged-in"]);
        }).catch(() => {
            localStorage.removeItem('booking_token');
            localStorage.removeItem('user');
            commit('setLoading', false);
        });
    },

    //booking a slot
    storeSlot({ commit, state}) {
        const data = {
            user_id: state.user.id,
            booking_time: state.chosenDateTime.split(' ')[1],
            booking_date: state.chosenDateTime.split(' ')[0],
            vehicle_make: state.vehicleMake,
            vehicle_model: state.vehicleModel
        }
        commit('setLoading', true);
        commit('setBookedSlots', [...state.bookedSlots, data]);
        axios.post(`${process.env.VUE_APP_API_URL}/bookings`, data, headers()).then(() => {
            commit('setLoading', false);
            commit('setNotification', notificationMessages["booking-confirm"])
        }).catch(() => {
            commit('setBookedSlots', state.bookedSlots.filter((slot) => slot.booking_date !== data.booking_date && slot.booking_time !== data.booking_time) );
            commit('setLoading', false);
        });
    },

    //fetching all the booked slots
    fetchBookedSlots({commit}) {
        commit('setLoading', true);
        axios.get(`${process.env.VUE_APP_API_URL}/bookings`, headers()).then((res) => {

            commit('setBookedSlots', res.data.data);
            commit('setLoading', false);
        }).catch(() => {
            commit('setLoading', false);
        });
    }
}
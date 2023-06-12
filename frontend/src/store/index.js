import { createStore } from 'vuex'
import * as booked from "@/store/modules/booked"
import * as main from "@/store/modules/main"

export default createStore({
//   state: {
//     user: null,
//     bookedSlots:[],
//     formPortalActivated: false,
//     formPortalLocation: '',
//     notification: '',
//     loading: false,
//     askConfirmation: false,
//     confirmationMessage: '',
//     chosenDateTime:'',
//     vehicleMake:'',
//     vehicleModel:'',
//     blockedDayAndTimes:[]
//   },
//   getters: {
//     bookedSlots(state){
//         return state.bookedSlots;
//     },
//     user(state) {
//       return state.user;
//     },
//     formPortalActivated(state) {
//         return state.formPortalActivated;
//     },
//     formPortalLocation(state) {
//         return state.formPortalLocation;
//     },
//     isRegistration(state) {
//         return state.formPortalLocation === 'reg';
//     },
//     notification(state) {
//         return state.notification;
//     },
//     loading(state) {
//         return state.loading;
//     },
//     askConfirmation(state) {
//         return state.askConfirmation;
//     },
//    confirmationMessage(state) {
//         return state.notificationMessage;
//     },
//     chosenDateTime(state) {
//         return state.chosenDateTime;
//     }
//   },
//   mutations: {
//     setBookedSlots(state, bookedSlots){
//         state.bookedSlots = bookedSlots;
//     },
//     setUser(state, user) {
//       state.user = user;
//     },
//     setFormPortalActivated(state, formPortalActivated) {
//       state.formPortalActivated = !!formPortalActivated;
//       state.formPortalLocation = formPortalActivated;
//     },
//     setNotification(state, notification) {
//         state.notification = notification;
//     },
//     setLoading(state, loading) {
//         state.loading = loading;
//     },
//     setAskConfirmation(state, askConfirmation) {
//         state.askConfirmation = askConfirmation;
//     },
//     setConfirmationMessage(state, notificationMessage) {
//         state.notificationMessage = notificationMessage;
//     },
//     setChosenDateTime(state, chosenDateTime) {
//         state.chosenDateTime = chosenDateTime;
//     },
//     setVehicleMake(state, vehicleMake) {
//         state.vehicleMake = vehicleMake;
//     },
//     setVehicleModel(state, vehicleModel) {
//         state.vehicleModel = vehicleModel;
//     }
// },
//   actions: {
//     getBookedSlots({commit}){
//         axios.get(`${process.env.VUE_APP_API_URL}/bookings`).then((response) => {
//             commit('setBookedSlots', response.data.data);
//             commit('setAskConfirmation', false);
//         }).catch((error) => {
//           console.log(error)
//         });
//     },
//     logUserOut({commit}) {
//         axios.get(`${process.env.VUE_APP_API_URL}/auth/logout`,headers()).then(() => {
//             localStorage.removeItem('booking_token');
//             commit('setUser', null);
//             commit('setNotification', notificationMessages["logged-out"]);
//         })
//     },
//     registerLogInUser({commit}, details) {
//         commit('setLoading', true);
//       const location = this.state.formPortalLocation === 'reg' ? `${process.env.VUE_APP_API_URL}/auth/register` : `${process.env.VUE_APP_API_URL}/auth/login`;
//       axios.post(location, details)
//           .then((response) => {
//             localStorage.setItem('booking_token', response.data.token);
//             commit('setUser', response.data.data);
//             commit('setFormPortalActivated', '')
//             commit('setLoading', false);
//             commit('setNotification', notificationMessages["logged-in"]);
//           })
//           .catch((error) => {
//             console.log(error);
//           });
//     },
//     loggedInUser({commit}) {
//         commit('setLoading', true);
//         axios.get(`${process.env.VUE_APP_API_URL}/auth/user`,headers()).then((response) => {
//             commit('setUser', response.data.data ? response.data.data : null);
//             commit('setLoading', false);
//             commit('setNotification', notificationMessages["logged-in"]);
//         }).catch((error) => {
//             commit('setLoading', false);
//             console.log(error);
//         });
//     },
//       storeSlot({ commit, state}) {
//
//           const data = {
//               user_id: state.user.id,
//               booking_time: state.chosenDateTime.split(' ')[1],
//               booking_date: state.chosenDateTime.split(' ')[0],
//               vehicle_make: state.vehicleMake,
//               vehicle_model: state.vehicleModel
//           }
//           commit('setBookedSlots', [...state.bookedSlots, data]);
//           axios.post(`${process.env.VUE_APP_API_URL}/bookings`, data, headers()).then((res) => {1
//               console.log(res.data.data);
//           }).catch((error) => {
//               commit('setBookedSlots', state.bookedSlots.filter((slot) => slot.booking_date !== data.booking_date && slot.booking_time !== data.booking_time) );
//               console.log(error)
//           });
//       },
//       fetchBookedSlots({commit}) {
//           axios.get(`${process.env.VUE_APP_API_URL}/bookings`, headers()).then((res) => {
//               commit('setBookedSlots', res.data.data);
//           }).catch((error) => {
//               console.log(error)
//           });
//       }
//   },
  modules: {
      main,
      booked
  }
})


import axios from "axios";
import {headers} from "@/utils";
import {timesSlots} from "@/utils";


    export const state = {
      blockedDayAndTimes:[],
      currentDayBlockedTimes: [],
      currentDate: new Date().toISOString().slice(0, 10),
      bookedLoading: false,
    }
    export const getters = {
        blockedDayAndTimes(state){
            return state.blockedDayAndTimes;
        },
        currentDayBlockedTimes(state){
            // remove all starting 0 from time
             return state.currentDayBlockedTimes.map(i=>i.replace(/^0+/, ''));

        },
        currentDate(state){
            return state.currentDate;
        },
        bookedLoading(state){
            return state.bookedLoading;
        }
    }
    export const mutations = {
        setBlockedDayAndTimes(state, blockedDayAndTimes){
            state.blockedDayAndTimes = blockedDayAndTimes;
        },
        setCurrentDayBlockedTimes(state, currentDayBlockedTimes){

            state.currentDayBlockedTimes = currentDayBlockedTimes;
        },
        setCurrentDate(state, currentDate){
            state.currentDate = currentDate;
        },
        setBookedLoading(state, bookedLoading){
            state.bookedLoading = bookedLoading;
        }
    }
    export const actions= {
        async fetchBlockedDayAndTimes({commit}){
            try {
                commit('setBookedLoading', true);
                const response = await axios.get(`${process.env.VUE_APP_API_URL}/blocked-dates-times`)
                commit('setBlockedDayAndTimes', response.data.data);
                commit('setBookedLoading', false);
            } catch (error) {
                commit('setBookedLoading', false);
            }
        },
        async fetchCurrentDayBlockedTimes({commit, state}, currentDate = null){
            try {
                commit('setBookedLoading', true);
                const response = await axios.get(`${process.env.VUE_APP_API_URL}/blocked-dates-times/${currentDate ? currentDate : state.currentDate}`)
                commit('setCurrentDayBlockedTimes', response.data.data.map(i=>i.time));
                commit('setBookedLoading', false);
            } catch (error) {
                commit('setBookedLoading', false);
            }
        },
        async setCurrentDate({commit}, currentDate){
            commit('setCurrentDate', currentDate);
        },
        async updateCurrentDayBlockedTimes({commit, state}, currentDayBlockedTimes){
            try {
                commit('setBookedLoading', true);
                commit('setCurrentDayBlockedTimes', [...state.currentDayBlockedTimes,currentDayBlockedTimes]);
                const data={
                    date: state.currentDate,
                    time: currentDayBlockedTimes
                }
                await axios.post(`${process.env.VUE_APP_API_URL}/blocked-dates-times`, data, headers())
                commit('setBookedLoading', false);

            } catch (err) {
                commit('setBookedLoading', false);
            }
        },
        async removeCurrentDayBlockedTimes({commit, state}, currentDayBlockedTimes){
            try {
                commit('setBookedLoading', true);

                commit('setCurrentDayBlockedTimes', state.currentDayBlockedTimes.filter(i=> i !== currentDayBlockedTimes));
                const data={
                    date: state.currentDate,
                    time: currentDayBlockedTimes
                }
                await axios.post(`${process.env.VUE_APP_API_URL}/remove/blocked-dates-times`, data, headers())
                commit('setBookedLoading', false);

            } catch (err) {
                commit('setBookedLoading', false);
            }
        },
        async blockAllSlotsForCurrentDay({commit, state}){
            try {
                commit('setBookedLoading', true);
                commit('setCurrentDayBlockedTimes', timesSlots)
                await axios.get(`${process.env.VUE_APP_API_URL}/remove/block-all-slots/${state.currentDate}`, headers())
                commit('setBookedLoading', false);
            } catch (err) {
                commit('setBookedLoading', false);
            }
        }
    }
<template>
  <div class="container">
    <div class="calendar">
      <div class="calendar-header">
        <span @click="prevDay">Prev</span>
        <h2>{{ currentDay }}</h2>
        <span @click="nextDay">Next</span>
      </div>
      <div class="time-slots">
        <div
            v-for="slot in slots"
            :key="slot"
            class="time-slot"
            :class="{ 'time-slot--booked': isBooked(slot), 'is-weekend': isWeekend}"
            :title="isWeekend ? 'Closed on weekends' : isBooked(slot) ? 'Unavailable' : 'Book slot'"
            @click="bookSlot(slot)"
        >
          {{ slot }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import { mapGetters, mapActions } from 'vuex';
import {notificationMessages} from "@/utils";

export default {
  name: "CalendarView",
  data() {
    return {
      currentDay: moment().format("YYYY-MM-DD"),
      slots: this.generateSlots()
    };
  },
  created() {
    this.refreshBookedSlots();
  },
  computed: {
    ...mapGetters(["user", "bookedSlots", "notification","bookedSlots", "currentDayBlockedTimes"]),
    isWeekend() {
      return moment(this.currentDay).isoWeekday() > 5;
    },
    takenSlotsToday() {
      return this.bookedSlots.filter(slot => slot.booking_date === this.currentDay).map(slot => slot.booking_time);
    }
  },
  methods: {
    ...mapActions(["fetchCurrentDayBlockedTimes"]),
    refreshBookedSlots() {
      this.fetchCurrentDayBlockedTimes(this.currentDay);
      this.$store.dispatch('fetchBookedSlots', this.currentDay)
    },

    //generating the slots
    generateSlots() {
      const slots = [];
      for (let i = 9; i <= 17; i += 0.5) {
        const hour = Math.floor(i);
        const minutes = i % 1 > 0 ? "30" : "00";
        slots.push(`${hour}:${minutes}`);
      }
      return slots;
    },
    isBooked(slot) {
      return this.takenSlotsToday.includes(slot) || this.currentDayBlockedTimes.includes(slot);
    },

    bookSlot(slot) {
      if(this.isWeekend){
        this.$store.commit('setNotification', notificationMessages["weekend-prompt"]);
        return;
      }
      if(this.user == null){
        this.$store.commit('setNotification', notificationMessages["login-prompt"]);
        return;
      }

      //this function is used to check if the slots are booked
      if (!this.isBooked(slot)) {
        let day =moment(this.currentDay).format("dddd");
        //get current day weekday
        this.$store.commit('setAskConfirmation', true)
        this.$store.commit('setConfirmationMessage', `Are you sure you want to book ${slot} on ${day} ${this.currentDay}?`)

        this.$store.commit('setChosenDateTime', `${this.currentDay} ${slot}`)

      }
    },

    //changing the day and skipping weekends
    prevDay() {
      const weekDay = moment(this.currentDay).format("dddd");
      const isMonday = weekDay === "Monday";
      this.currentDay = moment(this.currentDay).subtract(isMonday ? 3 : 1, "days").format("YYYY-MM-DD");
    },
    nextDay() {
      const weekDay = moment(this.currentDay).format("dddd");
      const isFriday = weekDay === "Friday";
      this.currentDay = moment(this.currentDay).add(isFriday ? 3 : 1, "days").format("YYYY-MM-DD");

    }
  },
  watch: {
    currentDay() {
      this.slots = this.generateSlots();
      this.refreshBookedSlots();
    }
  }
};
</script>

<style lang="scss" scoped>

.container {
  max-width: 1000px;
  width: 80%;
  padding-top: 2.5rem;
  padding-bottom: 1rem;
}

.calendar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  h2{
    color: white;
  //  make the header responsive
    @media (max-width: 275px) {
      font-size: 1rem;
    }
  }
  span{
    padding: .25rem;
    color: white;
    font-size: 1.25rem;
    &:hover{
      cursor: pointer;
      color: #ddd;
    }
  }
}
.time-slots {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
  grid-gap: 0.5rem;
}

.time-slot {
  padding: 0.5rem;
  border: 1px solid #ddd;
  text-align: center;
  cursor: pointer;
  color: white;
}

.time-slot--booked {
  background-color: #f8d7da;
  color: #721c24;
  cursor: not-allowed;
}
.is-weekend {
  background-color: red;
  color: #6c757d;
}
</style>

<template>
  <div class="booking-list booking">
    <h3 v-if="bookings.length" class="booking-list-title">Current Bookings for {{ currentDate }} </h3>
    <ul v-if="bookings.length">
      <li class="booking-item" v-for="booking in bookings" :key="booking">
        {{ booking.booking_time }} - {{ booking.user.name }}  - {{ booking.vehicle_make }} - {{ booking.vehicle_model }}
      </li>
    </ul>
    <h3 v-else class="booking-list-title">No bookings for {{ currentDate }} </h3>
    <div  class="blocked-times-list">
      <p>Please click the slots below to toggle availability</p>
      <ul>
        <li
            :key="currentDate+i" v-for="i in slots"
            :class="[currentDayBlockedTimes.includes(i) ? 'blocked' : 'available']"
            @click="toggleSlot(i)"
            :title="currentDayBlockedTimes.includes(i) ? `This slot is blocked for ${currentDate}` : `This slot is available for ${currentDate}`"
        >{{i}}
        </li>
      </ul>
    </div>
     <span @click="clearAllSlots" class="block-all" :title="`This will cancel all bookings and block all slots for ${currentDate}`">Block all slots</span>
  </div>
</template>

<style lang="scss" scoped>
.booking-list {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  ul{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1em;
    margin-bottom: 2em;
    list-style: none;
    li{
      padding: .5rem;
      background-color: red;
      color: white;
      &:hover{
        background-color: darkred;
        cursor: pointer;
      }
    }
  }
}
.booking-list-title {
  margin-bottom: 1em;
}
.booking-item {
  padding: 1em;
  border: 1px solid #666;
  margin-bottom: 1em;
  width: 100%;
  max-width: 600px;
  list-style: none;
  li{
    padding: .5rem;
    background-color: yellow;
    color: black;
  }
}
.blocked-times-list{
  p{
    margin-bottom: .25em;
    font-size: 1.5rem;
    text-align: center;
  }
}
.blocked-times-list{
  .available {
    background-color: yellow;
    color: black;
  }
  .blocked {
    background-color: red;
  }
}
.booking-list.booking{
  li.booking-item{
    text-align: center;
    background-color: lightgray;
    color: black;
    font-weight: bold;
  }
}
.block-all{
  background-color: bisque;
  padding: .5rem;
  color: black;
  border-radius: 5px;
  font-weight: bold;
  font-size: 1.5rem;
  &:hover{
    cursor: pointer;
    background-color: darkred;
  }
}

</style>
<script>
import { mapGetters, mapActions} from 'vuex';
import {timesSlots} from "@/utils";
import {toRaw} from "vue";
export default {
  name: 'BookingList',
  data: () => ({
    slots: timesSlots,
    blockedKey: 11111111,
    blockedTimes: []
  }),
  computed: {
    ...mapGetters(['bookedSlots', 'currentDate', "currentDayBlockedTimes"]),
    bookings() {
      if(!toRaw(this.bookedSlots).length) return [];
      return toRaw(this.bookedSlots).filter(i=>i.booking_date === this.currentDate)
    }
  },
  methods: {
    ...mapActions(['updateCurrentDayBlockedTimes', 'blockAllSlotsForCurrentDay', 'fetchCurrentDayBlockedTimes']),
    toggleSlot(slot) {
      if(!slot ) return;
      if(!this.currentDayBlockedTimes.includes(slot)){
        this.$store.dispatch('updateCurrentDayBlockedTimes', slot);
      }else{
        this.$store.dispatch('removeCurrentDayBlockedTimes', slot);
      }
    },
    clearAllSlots(){
      this.$store.dispatch('blockAllSlotsForCurrentDay');
    }
  },


  watch: {
    currentDate(val) {
      const date = new Date(val);
      if(date.getDay() === 0 || date.getDay() === 6){
        this.$store.dispatch('blockAllSlotsForCurrentDay');
      }
      this.fetchCurrentDayBlockedTimes()
    }
  }
}
</script>

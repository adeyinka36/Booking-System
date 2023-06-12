<template>
  <div class="time-slot-control">
    <label for="time-slot-control">Select a timeslot to disable/enable:</label>
<!--    <select id="time-slot-control" @change="toggleSlot" @click="remove" >-->
<!--      <option value="" selected>Select a timeslot</option>-->
<!--      <option v-for="slot in slots" :key="slot" :value="slot">{{ slot }}</option>-->
<!--    </select>-->
  </div>
</template>

<style scoped>
.time-slot-control {
  display: flex;
  flex-direction: column;
}
.time-slot-control label {
  margin-bottom: .5em;
}
.time-slot-control select {
  padding: .5em;
}
</style>
<script>
import { mapActions, mapGetters } from 'vuex';
export default {
  name: 'TimeSlotControl',
  data() {
    return {
      slots: ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
              '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
              '15:00', '15:30', '16:00', '16:30', '17:00'],

    }
  },
  computed: {
    ...mapGetters(['currentDayBlockedTimes'])
  },
  methods: {
    ...mapActions(['updateCurrentDayBlockedTimes', "removeCurrentDayBlockedTimes"]),
    toggleSlot(event) {
      console.log('======',event.target.value, this.currentDayBlockedTimes);
      if(!event.target.value || !this.currentDayBlockedTimes.includes(event.target.value)) return;
      this.$store.dispatch('updateCurrentDayBlockedTimes', event.target.value);
    },
    remove(event) {
      console.log(event.target)
      if(!event.target.value) return;
      if( this.currentDayBlockedTimes.includes(event.target.value)) {
        console.log(event.target.value, this.currentDayBlockedTimes);
        this.$store.dispatch('removeCurrentDayBlockedTimes', event.target.value);
      }
    }
  },
  watch: {
    date() {
      // Reset the select element when the date changes
      document.getElementById('time-slot-control').selectedIndex = 0;
    }
  }
}
</script>

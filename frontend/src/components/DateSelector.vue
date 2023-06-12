<template>
  <div class="date-selector">
    <label for="date-selector">Select a date to view bookings:</label>
    <input id="date-selector" type="date" @change="selectDate" :min="minDate" v-model="currentDate"/>
  </div>
</template>

<style scoped>
.date-selector {
  display: flex;
  flex-direction: column;
}
.date-selector label {
  margin-bottom: .5em;
}
.date-selector input {
  padding: .5em;
}
</style>
<script>
import { mapActions, mapGetters} from 'vuex';
export default {
  'name': 'DateSelector',
  methods: {
    ...mapActions(['setCurrentDate']),
    selectDate(event) {
      this.$store.dispatch('setCurrentDate', event.target.value)
    }
  },
  computed:{
    ...mapGetters(['currentDate']),
    minDate() {
      return new Date().toISOString().split('T')[0];
    }
  }
}
</script>

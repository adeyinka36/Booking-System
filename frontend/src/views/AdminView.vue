<template>
  <div class="admin">
    <h2 class="admin-title">Admin Dashboard</h2>
    <div class="admin-controls">
      <DateSelector />
    </div>
    <BookingList />
  </div>
</template>

<style scoped>
.admin {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-around;
  padding: 1em;
  background-color: #333;
  color: #fff;
}
.admin-title {
  margin-bottom: 1em;
}
.admin-controls {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1em;
  margin-bottom: 2em;
}
</style>

<script>
import DateSelector from "@/components/DateSelector";
import BookingList from "@/components/BookingList";
import moment from "moment/moment";
import {mapGetters, mapActions} from "vuex";

export default {
  components: {
    DateSelector,
    BookingList
  },
  data() {
    return {
      bookings: this.bookedSlots,
      selectedDate: moment().format("YYYY-MM-DD"),
      disabledSlots: this.currentDayBlockedTimes
    }
  },
  computed: {
    ...mapGetters(["currentDayBlockedTimes", "bookedSlots"]),
  },
  methods: {
    ...mapActions(["fetchBookedSlots", "fetchCurrentDayBlockedTimes"]),

    toggleSlot(blockedSlots) {
      this.disabledSlots = blockedSlots;
    }
  },
  created() {
    this.fetchBookedSlots();
    this.fetchCurrentDayBlockedTimes();
    this.$store.dispatch('loggedInUser')
  },
  mounted() {
    let user = JSON.parse(localStorage.getItem('user'));
    setTimeout(() => {
      this.$store.commit('setNotification', `Welcome ${user.name}!`);
    }, 5000);
  }
}
</script>

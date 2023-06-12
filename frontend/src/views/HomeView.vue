<template>
  <div class="main-con">
    <p class="choose">Please select a slot</p>
    <CalendarView v-if="!formPortalActivated"/>
    <RegistrationLoginForm  v-else/>
    <p>Email: paul@gmail.com</p>
    <teleport to="body">
      <ConfirmationView />
    </teleport>
  </div>
</template>


<script>
import CalendarView from "@/views/CalendarView.vue";
import RegistrationLoginForm from "@/views/RegistrationLoginForm";
import ConfirmationView from "@/views/ConfirmationView";
import { mapGetters, mapActions } from 'vuex';

export default {
  name: "HomeView",
  components: {
    CalendarView,
    RegistrationLoginForm,
    ConfirmationView
  },
  created() {
    this.$store.dispatch('fetchBookedSlots')
    this.$store.dispatch('loggedInUser')
  },
  computed: {
    ...mapGetters(["formPortalActivated"])
  },
  methods: {
    ...mapActions(["getBookedSlots", "loggedInUser"]),
  },
  mounted() {
  //  check router for a param called message and if it exists, set it as the notification
    if (this.$route.query.message) {
      setTimeout(()=>{
        this.$store.commit('setNotification', this.$route.query.message);
        this.$router.replace({'query': ''});
      }, 3000)
    }
  }

};
</script>
<style lang="scss">
.main-con{
  min-height: 100vh;
  background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0 , 0, 0.7)), url('../assets/car.jpg');
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  .menu{
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
  }
}
p{
  color: white;
  font-weight: bold;
}
.choose{
  color: white;
  font-weight: bold;
  font-size: 1.5rem;
  letter-spacing: .1rem;
}
</style>



<template>
  <div class="modal-overlay" v-if="askConfirmation">
    <div class="modal-content">
      <h2>Confirm Booking</h2>
      <p>{{confirmationMessage}}</p>

      <form @submit.prevent="confirmBooking">
        <div class="form-group">
          <label for="make">Vehicle Make:</label>
          <input type="text" id="make" v-model="vehicle.make" required>
        </div>
        <div class="form-group">
          <label for="model">Vehicle Model:</label>
          <input type="text" id="model" v-model="vehicle.model" required>
        </div>

        <button type="submit" class="confirm" @click="confirmBooking">Confirm</button>
        <button type="button" @click="cancelBooking" class="cancel">Cancel</button>
      </form>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { notificationMessages } from "@/utils";

export default {
  name: 'ConfirmationView',
  data() {
    return {
      showModal: false,
      vehicle: {
        make: '',
        model: '',
      }
    }
  },
  computed: {
    ...mapGetters(["askConfirmation", "confirmationMessage"])
  },
  methods: {
    confirmBooking() {
      if(!this.vehicle.make || !this.vehicle.model) {
        alert("Please enter vehicle make and model")
        return
      }
      this.$store.commit('setVehicleMake', this.vehicle.make)
      this.$store.commit('setVehicleModel', this.vehicle.model)
      this.$store.dispatch('storeSlot')
      this.$store.commit('setAskConfirmation', false)
      this.make = ''
      this.model = ''
    },
    cancelBooking() {
      this.$store.commit('setNotification', notificationMessages["booking-cancel"])
      this.$store.commit('setAskConfirmation', false)
    }
  }
}
</script>

<style lang="scss" scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-content {
  background-color: #333;
  color: #fff;
  padding: 20px;
  border-radius: 10px;
  width: 90%;
  max-width: 500px;
}

button {
  background-color: #555;
  color: #fff;
  border: none;
  padding: 10px;
  margin: 10px;
  cursor: pointer;
}

button:hover {
  background-color: #777;
}
.confirm{
  margin-left: 0;
}
.cancel{
  background-color: red;
}
form{
  margin-top: 1.5rem;
}
.form-group {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-bottom: 20px;
  input{
    height: 2rem;
    font-size: 1rem;
    font-weight: bold;
    padding: 10px;
    border-radius: 5px;
    border: none;
    margin-top: 5px;
  }
}

label {
  margin-bottom: 5px;
}

p{
  font-weight: bold;
  margin-bottom: .5rem;
  margin-top: .5rem
}
@media (max-width: 768px) {
  .form-group {
    width: 100%;
  }
}
</style>

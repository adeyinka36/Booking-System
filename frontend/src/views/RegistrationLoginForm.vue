<template>
  <div class="main">
  <div class="container">
    <form @submit.prevent="submitForm">
      <div v-if="isRegistration" class="form-group">
        <label for="first_name">First Name</label>
        <input v-model="form.first_name" type="text" id="first_name" required>
      </div>

      <div v-if="isRegistration" class="form-group">
        <label for="last_name">Last Name</label>
        <input v-model="form.last_name" type="text" id="last_name" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="form.email" type="email" id="email" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input v-model="form.password" type="password" id="password" required>
      </div>

      <div v-if="isRegistration" class="form-group">
        <label for="phone_number">Phone Number</label>
        <input v-model="form.phone_number" type="tel" id="phone_number" required>
      </div>

      <button v-if="!loading" type="submit">{{ isRegistration ? 'Register' : 'Login' }}</button>
      <button v-if="!loading"  class="cancel" @click="closeModal">Cancel</button>
      <button v-else type="submit" disabled class="submit">...Submitting</button>
    </form>
  </div>
  </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex';
export default {
  name: 'RegistrationLoginForm',
  data() {
    return {
      form: {
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        phone_number: '',
      },
    };
  },
  computed: {
    ...mapGetters(["isRegistration", "loading"])
  },
  methods: {
    ...mapActions(["registerLogInUser"]),
    async submitForm() {
      this.registerLogInUser(this.form)
    },
    closeModal() {
      this.$store.commit('setFormPortalActivated', '')
    }
  },
};
</script>

<style scoped>
.main{
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  min-height: 100vh;
  background-color: rgba(0,0,0,0.7);
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
}
.container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background: #333;
  color: #fff;
}
.form-group {
  margin-bottom: 15px;
}
.form-group label {
  display: block;
  margin-bottom: 5px;
}
.form-group input {
  width: 100%;
  padding: 10px;
  border: none;
  background: #666;
  color: #fff;
}
button {
  padding: 10px 20px;
  border: none;
  background: #00A86B;
  color: #fff;
  cursor: pointer;
  width: 5rem;
  margin: .25rem .25rem .25rem 0;
}
.cancel{
  background: #ff0000;
}
.submit{
  width: auto;
}
button:hover {
  background: #009954;
}
</style>

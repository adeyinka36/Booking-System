<template>
  <div class="header">
    <div class="logo" @click="()=>$router.push('/')" title="Home">Hayden's</div>
    <div class="nav-container">
      <nav v-if="!user">
        <span @click="()=>gotToModal('login')">{{ loading ? '' : 'Login' }}</span>
        <span @click="()=>gotToModal('reg')">{{ loading ? '' : 'Register' }}</span>
      </nav>
      <nav v-else>
        <span class="name">{{user.name}}</span>
        <span class="logout" @click="logUserOut">Logout</span>
      </nav>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: "HeaderView",
  computed: {
    ...mapGetters(["user","loading"])
  },
  methods: {
    ...mapActions(["logUserOut"]),
    gotToModal(location) {
      this.$store.commit('setFormPortalActivated', location)
    }
  }
}
</script>

<style lang="scss" scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #333;
  color: #fff;
  padding: 10px;
  .logo{
    color: bisque;
    font-weight: bold;
    font-size: 1.5rem;
    &:hover {
      cursor: pointer;
      color: darken(bisque, 10%);
    }
  }
}

.nav-container {
  display: flex;
  nav{
    display: flex;
    align-items: center;
    justify-content: center;
    span{
      &:hover {
        cursor: pointer;
        color: darken(bisque, 10%);
      }
    }
  }
}

nav span {
  color: #fff;
  text-decoration: none;
  margin-right: 10px;
  font-size: 1.3rem;
}
.name{
  color: bisque;
  font-weight: bold;
  font-size: 1rem;
}
.logout{
    color: red;
    font-weight: bold;
    font-size: 1rem;
    &:hover {
      cursor: pointer;

  }
}
@media (max-width: 600px) {
  .nav-container {
    flex-direction: column;
  }
}
</style>

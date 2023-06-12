<template>
 <div id="app">
   <div id="nav">
     <HeaderView class="menu"/>
   </div>
   <router-view/>
   <teleport to="body">
     <LoadingView />
    </teleport>
   <span ref="notification" class="notification">{{ notification }}</span>
 </div>
</template>


<script>
import LoadingView from "@/views/LoadingView";
import {mapGetters} from "vuex";
import HeaderView from "@/components/HeaderView";

export default {
 name: 'App',
  components: {LoadingView, HeaderView},
  computed: {
    ...mapGetters(["notification"])
  },
  watch: {
    notification(value) {
      if (value === '') return;
      this.$refs.notification.style.right = "1rem";
      setTimeout(() => {
        this.$refs.notification.style.right = "-100%";
      }, 3000);
      setTimeout(() => {
        this.$store.commit('setNotification', '');
      }, 4000);
    }
  }
};
</script>
<style lang="scss" scoped>
#app{
  min-height: 100vh;
  #nav{
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-weight: bold;
    font-size: 2rem;
    letter-spacing: .25rem;
    a{
      width: 100%;
      color: white;
      text-decoration: none;
      background-color: darkgreen;
      margin: 0;
      text-align: center;
    }
    .menu{
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
    }

  }
  .notification{
    position: fixed;
    top: 5rem;
    right: -100%;
    color: black;
    padding: 1rem;
    font-weight: bold;
    width: auto;
    background-color: yellow;
    border-radius: 10px;
    transition: all 1s ease-in-out;
    text-align: center;
  }
}

</style>


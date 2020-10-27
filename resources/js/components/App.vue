<template>

    <div class="container">
        <TheHeader :isLoggedIn="isLoggedIn" @loggedInStatus="changeLoggedInStatus"/>
        <Modal />
        <router-view @loggedInStatus="changeLoggedInStatus" class="content"></router-view>
    </div>

</template>

<script>

import TheHeader from './TheHeader.vue';
import Modal from './Modal.vue';

export default {
  name: 'App',
  components: {
    TheHeader,
    Modal,
  },
  data(){
    return {
      isLoggedIn: localStorage.getItem('user') != null
    }
  },
  methods: {
    changeLoggedInStatus: function(){
      this.isLoggedIn= localStorage.getItem('user') != null;
    }
  },
}

</script>

<style scoped>

  .container{
    max-width: 1920px;
    margin: 0px auto;
    height: auto;
    position: relative;
    overflow: hidden;
  }

  .content{
    margin-top: 60px;
  }
  
</style>

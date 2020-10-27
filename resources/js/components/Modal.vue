<template>

    <div class="wrapper" v-show="modalData.display">

      <div class="modal-box">

          <div class="header">

            <p @click="hideModal"><img src="/images/cross-btn.png"/></p>

          </div>

          <div class="main-content">

            <div class="content" v-for="data in modalData.msg" v-bind:key="data">{{data}}</div>

          </div>

      </div>
        
    </div>

</template>

<script>

export default {
  name: 'Modal',
  computed: {
    modalData(){
      return this.$store.state.ModalData;
    }
  },
  methods: {
    hideModal(){
      this.$store.state.ModalData.display= false;
    }
    
  },

}

</script>

<style scoped>

    .wrapper{
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #000;
        position: absolute;
        z-index: 999;
        opacity: .9;
        position: fixed;
    }

    .modal-box{
      width: 300px;
      min-height: 200px;
      background: #FFF;
    }

    .header{
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding-right: 5px;
    }

    .header img{
      width: 25px;
      height: 25px;
      cursor: pointer;
    }

    .main-content{
      padding: 10px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      min-height: 150px;
    }

    .content{
      margin-bottom: 15px;
      border-bottom: 1px solid lightgray;
      width: 100%;
      text-align: center;
      color: #4B3049;
    }

    .content:last-child{
      margin-bottom: 0px;
    }
  
</style>
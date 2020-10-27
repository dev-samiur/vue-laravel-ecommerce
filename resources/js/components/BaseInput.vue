<template>

    <input :type="inputDetails.type" :name="inputDetails.name" :placeholder="inputDetails.name" v-on:keyup="keyUpped" v-model="inputedVal"/>

</template>

<script>

export default {
  name: 'BaseInput',
  props: {
      inputDetails: {
          type: Object,
          required: true
      }
  },
  data(){
    return{
      inputedVal: ''
    }
  },
  methods: {
    keyUpped(){
      this.$emit('keyUpped', this.inputedVal);
    }
  }
}

</script>

<style scoped>

  input{
      height: 50px;
      width: 250px;
      padding-left: 5px;
      color: #4B3049;
      display: block;
      border: 0px;
      border-radius: 5px;
      background: #FFF;
      font-size: 14px;
  }
</style>

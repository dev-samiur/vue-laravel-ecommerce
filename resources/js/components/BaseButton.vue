<template>

    <button :style="styleObject" @click.prevent="btnClicked">{{ButtonDetails.title}}</button>
    
</template>

<script>

export default {
  name: 'BaseButton',
  props: {
      ButtonDetails: {
          type: Object,
          required: true
      }
  },
  computed: {
      styleObject(){
          return{
              '--bg': this.$props.ButtonDetails.bg,
              '--color': this.$props.ButtonDetails.color,
              '--hoverBg': this.$props.ButtonDetails.hoverBg,
              '--hoverColor': this.$props.ButtonDetails.hoverColor,
          }
      }
  },
   methods: {
    btnClicked: function(){
      this.$emit('btnClicked')
    }
  }
}

</script>

<style scoped>

    button{
        height: 40px;
        width: 150px;
        border: 0px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 1s;
        display: block;
        border-radius: 5px;
        background: var(--bg);
        color: var(--color);
    }

    button:hover{
        background: var(--hoverBg);
        color: var(--hoverColor);
    }

</style>

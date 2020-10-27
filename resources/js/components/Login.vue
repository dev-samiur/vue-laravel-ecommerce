<template>

    <div class="wrapper">

        <div class="form-container">

            <form action="" method="">

              <div class="headline">Login</div>

              <BaseInput v-bind:input-details="inputDetails[0]" class="input-field" @keyUpped="setEmail"/>
              <BaseInput v-bind:input-details="inputDetails[1]" class="input-field" @keyUpped="setPass"/>
              <BaseButton v-bind:button-details="buttonDetails[0]" v-on:btnClicked="btnClicked" :disabled="isDisabled"/>

            </form>

        </div>
        
    </div>

</template>

<script>
import BaseInput from './BaseInput.vue';
import BaseButton from './BaseButton.vue';

export default {
  name: 'Login',
  components: {
    BaseInput,
    BaseButton
  },
  data() {
    return{
      inputDetails:[
        {'type':'email','name': 'email'},
        {'type':'password','name': 'password'}
      ],
      buttonDetails:[
        {'title': 'Submit', 'bg': '#FFF', 'color': '#4B3049', 'hoverBg': '#4B3049', 'hoverColor':'#FFF'}
      ],
      inputedData: {
        email: '',
        password: '',
      },
      product: this.$route.params.product,
    }
  },
  computed: {

    isDisabled: function()
    {
      if(this.inputedData.email != '' && this.inputedData.password != '')
        return false;
      else
        return true;
    }
  },
  methods: {

    btnClicked: function(){
      
      axios({
        method: 'post',
        url: '/api/login',
        data: this.inputedData
      })
      .then( response => {
        if(response.data.error)
        {
          this.$store.state.ModalData.msg.length=0;
          this.$store.state.ModalData.display= true;
          this.$store.state.ModalData.msg.push('Wrong email or password');
        }
        else
        {
          let user = JSON.stringify(response.data.user);
          let token = response.data.token;
          
          localStorage.setItem('user', user);
          localStorage.setItem('token', token);
          this.$emit('loggedInStatus');

          //redirect the user to show page (if the user was not logged in and press order button)
          
          if(this.product != null)
           {
             this.$router.push({
                  name: 'show',
                  params: {product: this.product}
              });
           }
          else  
            this.$router.push('/dashboard/'+response.data.user.usertype);
        }
      });

    },

    setEmail: function($event)
    {
      this.inputedData.email= $event;
    },

    setPass: function($event)
    {
      this.inputedData.password= $event;
    },
  },
  beforeCreate(){
    if(this.$parent.isLoggedIn)
      this.$router.push('/');
  },
}

</script>

<style scoped>

    .wrapper{
        width: 100vw;
        height: calc(100vh - 60px);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-container{
        width: 300px;
        height: 400px;
        background: #B08EAD;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .headline{
        font-size: 26px;
        font-weight: 500;
        margin-bottom: 50px;
        color: #FFF;
    }

    .input-field{
        margin-bottom: 20px;
    }
  
</style>
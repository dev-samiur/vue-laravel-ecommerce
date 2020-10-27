<template>

    <div class="wrapper">

        <div class="form-container">

            <form action="" method="">
              
              <div class="headline">Register</div>

              <BaseInput v-bind:input-details="inputDetails[0]" class="input-field" @keyUpped="setName"/>
              <BaseInput v-bind:input-details="inputDetails[1]" class="input-field" @keyUpped="setEmail"/>
              <BaseInput v-bind:input-details="inputDetails[2]" class="input-field" @keyUpped="setPass"/>

              <div class="radio-contaner input-field">

                <p class="radio-headline input-field">Are you a:</p>

                <input type="radio" id="buyer" name="user_type" value="2" v-model="inputedData.usertype">
                <label for="buyer">Buyer</label>
                <input type="radio" id="seller" name="user_type" value="3" v-model="inputedData.usertype">
                <label for="seller">Seller</label><br>

              </div>

              <BaseButton v-bind:button-details="buttonDetails[0]" v-on:btnClicked="btnClicked" :disabled="isDisabled"/>

            </form>


        </div>
        
    </div>

</template>

<script>
import BaseInput from './BaseInput.vue';
import BaseButton from './BaseButton.vue';


export default {
  name: 'Register',
  components: {
    BaseInput,
    BaseButton
  },
  data() {

    return{

      inputDetails:[
        {'type':'text','name': 'username'},
        {'type':'email','name': 'email'},
        {'type':'password','name': 'password'}
      ],

      buttonDetails:[
        {'title': 'Submit', 'bg': '#FFF', 'color': '#4B3049', 'hoverBg': '#4B3049', 'hoverColor':'#FFF'}
      ],

      inputedData: {
        name: '',
        email: '',
        password: '',
        usertype:''
      },

    }
    
  },

  computed: {

    isDisabled: function()
    {
      if(this.inputedData.name != '' && this.inputedData.email != '' && this.inputedData.password != '' && this.inputedData.usertype != '')
        return false;
      else
        return true;
    }

  },

  methods: {

    btnClicked: function(){
      
      axios({
        method: 'post',
        url: '/api/register',
        data: this.inputedData
      })
      .then( response => {
        if(response.data.error)
        {
          this.$store.state.ModalData.msg.length=0;

          this.$store.state.ModalData.display= true;

          if(response.data.error.name)
            this.$store.state.ModalData.msg.push(response.data.error.name[0]);
          if(response.data.error.email)
            this.$store.state.ModalData.msg.push(response.data.error.email[0]);
          if(response.data.error.password)
            this.$store.state.ModalData.msg.push(response.data.error.password[0]);

          if(response.data.error.errorInfo)
          {
            if(response.data.error.errorInfo[1] == 1062)
              this.$store.state.ModalData.msg.push('Email already exists');
            else
              this.$store.state.ModalData.msg.push('Error!!');
          }
            
        }
        else
        {
          let user = JSON.stringify(response.data.user);
          let token = response.data.token;

          localStorage.setItem('user', user);
          localStorage.setItem('token', token);
          this.$emit('loggedInStatus');
          this.$router.push('/dashboard/'+response.data.user.usertype);
        }
      });

    },

    setName: function($event)
    {
      this.inputedData.name= $event;
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
        this.$router.push('/dashboard');
    }
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
        height: 500px;
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

    .radio-headline{
      width: 250px;
      color: #FFF;
    }

    label{
      color: #FFF;
      font-size: 16px;
      float: left;
    }

    input[type="radio"]{
      width: 20px;
      height: 20px;
      float: left;
      margin-right: 10px;
      background: #FFF !important;
    }

    #seller{
      margin-left: 20px;
    }
  
</style>
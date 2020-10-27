<template>

    <div class="nav">
        <div class="nav-brand"><router-link to="/">intérieur</router-link></div>
        <div class="nav-menu">

          <ul v-if="!isLoggedIn">
            <li class="nav-item"><router-link to="/register">Register</router-link></li>
            <li class="nav-item"><router-link to="/login">Login</router-link></li>
          </ul>

          <ul v-else>
            <li class="nav-item"><router-link :to="homelink">Home</router-link></li>
            <li class="nav-item"><a @click="logout">Logout</a></li>
          </ul>
          
        </div>
    </div>

</template>

<script>

export default {
  name: 'TheHeader',
  data(){
    return{
      user: JSON.parse(localStorage.getItem('user')),
      windowWidth: null,
    }
  },
  computed: {
    homelink(){
      let u= JSON.parse(localStorage.getItem('user'));
      return '/dashboard/'+u.usertype;
    }
  },
  props: {
      isLoggedIn: {
          type: Boolean,
          required: true
      }
  },
  methods: {
    logout: function()
    {
      axios({
        method: 'post',
        url: '/api/logout',
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
      })
      .then( response => {
         localStorage.removeItem('token');
         localStorage.removeItem('user');
         this.$emit('loggedInStatus');
         this.$router.push('/');
      });
    },
  },

}

</script>

<style scoped>

    .nav{
      max-width: 1920px;
      width: 100%;
      height: 60px;
      display: flex;
      background: #B08EAD;
      position: fixed;
      z-index: 999;
    }

    .nav-brand{
        width: 300px;
        text-align: center;
        line-height: 60px;
        font-size: 30px;
        font-weight: 500;
        margin-left: 50px;
        color: #FFF;
        cursor: pointer;
    }

    .nav-brand a{
      font-size: 30px;
      font-weight: 500;
      color: #FFF;
      cursor: pointer;
      text-decoration: none;
    }

    .nav-menu{
      width: 100%;
    }

    ul{
      list-style: none;
      height: 100%;
      float: right;
      display: flex;
      margin-right: 50px;
      align-items: center;
    }

    li:first-child{
      margin-right: 15px;
    }

    li a{
      text-decoration: none;
      color: #F4F4F4;
      cursor: pointer;
      font-size: 15px;
    }

    li a:hover{
      color:#FFF;
    }


    @media screen and (max-width: 600px)
    {
      .nav-brand{
          width: 150px;
          margin-left: 15px;
      }

      .nav-brand a{
        font-size: 24px;
      } 

      ul{
        margin-right: 15px;
        font-size: 14px;
      }
    }

     @media screen and (max-width: 400px)
    {
      .nav-brand a{
          font-size: 22px;
      }

      li a{
        font-size: 14px;
      }
    }
  
</style>

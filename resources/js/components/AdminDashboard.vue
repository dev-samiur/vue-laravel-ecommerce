<template>

    <div class="container">

        <div class="header">

            <div class="brand">Admin</div>

        </div>

        <div class="main">
        
            <div class="cart" v-for="user in users" :key="user.id">

                    <div class="item"><span>Name: </span>{{user.name}}</div>
                    <div class="item"><span>User Type: </span>{{user.usertype}}</div>
                    <div class="item" @click="deleteUser(user['id'])">Delete</div>

            </div>

        </div>

    </div>

</template>

<script>

export default {

    data(){
        return{
            admin: JSON.parse(localStorage.getItem('user')),
            users: null,
        }
    },

    methods: {

        retrieveUsers(){

            axios({
                method: 'post',
                url: '/api/users',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then( response => {
                this.users= response.data;
            })

        },

        deleteUser(id){

            axios({
                method: 'post',
                url: '/api/user/delete',
                data: {id: id},
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then( response => {
                location.reload();
            })
        },

    },

    beforeCreate(){
        
        let user= JSON.parse(localStorage.getItem('user'));
        
        if(user.usertype != 1)
            this.$router.push('/dashboard/'+user.usertype);
    
    },

    created(){
        this.retrieveUsers();
    },
}

</script>

<style scoped>

    .header{
        padding: 20px;
        border-bottom: 1px solid #ccc;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
    }

    .brand{
        font-size: 36px;
        color: #4B3049;
    }

    .main{
        padding: 20px;
    }

    .cart{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        font-size: 15px;
        width: 300px;
        background: #4B3049;
        color: #fff;
        padding: 20px;
        margin-bottom: 20px;
    }

    .item{
        margin-bottom: 10px;
    }

    .item span{
        font-size: 18px;
        font-weight: 500;
    }

    .item:last-child{
        margin-bottom: 0px;
        margin-top: 10px;
        background: #FFF;
        height: 50px;
        width: 150px;
        color: #4B3049;
        line-height: 50px;
        text-align: center;
        font-weight: 500;
        cursor: pointer;
        transition: all 1.5s;
    }

    .item:last-child:hover{
        background: #4B3049;
        color: #FFF;
        border: 1px solid #FFF;
    }
  
</style>

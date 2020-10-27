<template>

    <div class="container">

        <div class="header">

            <div class="brand">{{user.name}}</div>

        </div>

        <div class="main">

            <div class="cart" v-if="orderExists">

                <div class="item"><span>Product: </span>{{productName}}</div>
                <div class="item"><span>Payment: </span>Cash on delivery</div>
                <div class="item" @click="orderProduct">Confirm Order</div>

            </div>

            <div class="order-status" v-else>No item in the cart</div>

        </div>

    </div>

</template>

<script>

export default {
    data(){

        return{
            user: JSON.parse(localStorage.getItem('user')),
            order: this.$store.state.Orderdata,
            productName: this.$store.state.Orderdata.product_name,
        }
        
    },

    computed: {
        orderExists(){
            return this.order.order != null;
        }
    },

    beforeCreate(){
        
        let user= JSON.parse(localStorage.getItem('user'));
        
        if(user.usertype != 2)
            this.$router.push('/dashboard/'+user.usertype);
    
    },

    methods: {

        orderProduct(){

            axios({
                method: 'post',
                url: '/api/order/create',
                data: {data: this.order},
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then( response => {
                this.$store.state.ModalData.msg.length=0;
                this.$store.state.ModalData.display= true;
                this.$store.state.ModalData.msg.push(response.data);
                this.$store.state.Orderdata.order= null;
                this.$store.state.Orderdata.order_to= null;
            })

        }
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

    .order-status{
        font-size: 20px;
        color: #4B3049;
    }
  
</style>

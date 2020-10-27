<template>

    <div class="container">

        <AddProductForm :displayForm="displayForm" @hideModal="hideModal" />
        
        <div class="header">
            <div class="brand">{{user.name}}</div>
            <div @click="addNewProduct" class="add-new-product">Add New Product</div>
        </div>
        
        <Products @showProduct="showProduct" :products="products" :headline="headline"/>

        <div class="order-container">

            <div class="header">
                <div class="brand">Pending Orders</div>
            </div>

            <div class="order-main">

               <div class="cart-wrapper" v-if="orderExists">

                   <div class="cart" v-for="order in orders" :key="order.id">

                        <div class="item"><span>Product: </span>{{order['product_name']}}</div>
                        <div class="item"><span>Order By: </span>{{order['orderer_name']}}</div>
                        <div class="item" @click="completeOrder(order['id'])">Complete Order</div>

                    </div>

               </div>

                

                <div class="order-status" v-else>No pending orders</div>

            </div>

        </div>

    </div>

</template>

<script>

import AddProductForm from './AddProductForm.vue';
import Products from './Products.vue';

export default {
    data(){
        return{
            user: JSON.parse(localStorage.getItem('user')),
            displayForm: false,
            productsRetreiveInfo:'seller',
            products: {},
            headline: "My Products",
            orders: null,
        }
    },
    computed: {
        orderExists(){
            if(this.orders != null && this.orders.length != 0)
                return true;
            else
                return false;
        }
    },
    components:{
        AddProductForm,
        Products,

    },
    methods: {

        addNewProduct(){
            this.displayForm= true;
        },
        
        hideModal(){
           this.displayForm= false; 
        },

        showProduct($event)
        {
            this.$router.push({
                name: 'show',
                params: {product: $event}
            });
        },

        retrieveProducts(){

            axios({
                method: 'post',
                url: '/api/dashboard/products',
                data: {productsRetreiveInfo: this.productsRetreiveInfo},
                headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then( response => {
                this.products= response.data;
            })
        },

        retrieveOrders(){

            axios({
                method: 'post',
                url: '/api/order/get',
                headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then( response => {
                this.orders= response.data;
            })
        },

        completeOrder(id){

            axios({
                method: 'post',
                url: '/api/order/complete',
                data: {order_id: id},
                headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then( response => {
                
                if(response.data == 'success')
                    location.reload();
                else
                {
                    this.$store.state.ModalData.msg.length=0;
                    this.$store.state.ModalData.display= true;
                    this.$store.state.ModalData.msg.push('You need a buyer account to buy something');
                }
            })
        }
    },

    beforeCreate(){
        
        let user= JSON.parse(localStorage.getItem('user'));
        
        if(user.usertype != 3)
            this.$router.push('/dashboard/'+user.usertype);
        
    },

    created(){

        this.retrieveProducts();
        this.retrieveOrders();

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

    .add-new-product{
        height: 50px;
        width: 130px;
        background: #4B3049;
        color: #FFF;
        border: 0px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 500;
        text-align: center;
        line-height: 50px;
        margin-top: 10px;
    }

    .order-main{
        padding: 50px;
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
        margin-top: 20px;
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

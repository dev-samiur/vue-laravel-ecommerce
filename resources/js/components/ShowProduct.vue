<template>

    <div class="container">

        <div class="product-info">

             <div class="image-container">

                 <img :src="imagePath"/>

             </div>

             <div class="product-content">

                <div class="info">{{product.name}}</div>
                <div class="info">Catagory: {{product.catagory}}</div>
                <div class="info">Price: {{product.price}}</div>

             </div>



        </div>

        <div class="product-des">

            <div class="description">
                <span class="headline">Description: </span>
                {{product.description}}
            </div>

            <div class="button-wrapper">

                <BaseButton v-bind:button-details="buttonDetails[0]" v-on:btnClicked="btnClicked" class="btn"/>
            
            </div>

        </div>

    </div>

</template>

<script>

import BaseButton from './BaseButton.vue';

export default {

    components:{
        BaseButton,
    },

    data(){

        return{

            product: this.$route.params.product,
            imagePath: '/images/'+this.$route.params.product.image,
            buttonDetails:[
                {'title': 'Order', 'bg': '#B08EAD', 'color': '#FFF', 'hoverBg': '#FFF', 'hoverColor':'#B08EAD'}
            ],

        }
    },

    methods: {

        btnClicked(){
            
            if(this.buttonDetails[0].title == 'Delete')
            {
                this.deleteProduct();
            }

            else
            {
                this.order();
            }
        },

        deleteProduct(){

            axios({
                method: 'post',
                url: '/api/delete',
                data: {id:this.product.id},
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then( response => {
                this.$router.push('/dashboard/3');
            })
        },

        order(){

            if(this.$parent.isLoggedIn)
            {

                let user= JSON.parse(localStorage.getItem('user'));
        
                if(user.usertype != 2)
                {
                    this.$store.state.ModalData.msg.length=0;
                    this.$store.state.ModalData.display= true;
                    this.$store.state.ModalData.msg.push('You need a buyer account to buy something');
                }

                else
                {
                    this.$store.state.Orderdata.order= this.product.id;
                    this.$store.state.Orderdata.order_to= this.product.user;
                    this.$store.state.Orderdata.product_name= this.product.name;
                    this.$router.push('/dashboard/2');
                }

            }

            else{
                this.$router.push({
                    name: 'login',
                    params: {product: this.product}
                });
            }

        }
    },

    mounted(){

        if(this.$parent.isLoggedIn)
        {
            let user= JSON.parse(localStorage.getItem('user'));

            console.log(user.usertype);

            if(user.usertype==3 || user.usertype==1)
            {
                if(user.id==this.product.user)
                    this.buttonDetails[0].title="Delete";
                
                if(user.usertype==1)
                    this.buttonDetails[0].title="Delete";
            }
        }
    },

    beforeCreate(){

        if(!this.$route.params.product)
            this.$router.push('/');
    }
}

</script>

<style scoped>

    .container{
        min-height: calc(100vh - 60px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 50px 20px;
    }

    .product-info{
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .product-des{
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-top: 100px;
    }

    .image-container{
        width: 400px;
        height: 400px;
    }

    img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-content{
        width: 300px;
        height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .info{
        margin-bottom: 5px;
        color: #4B3049;
        font-size: 20px;
    }

    .info:last-child{
        margin-bottom: 0px;
        color: #B08EAD;
    }

    .description{
        width: 100%;
        min-height: 100px;
        padding: 10px;
        color: #4B3049;
        font-size: 18px;
    }

    .headline{
        color: #B08EAD;
        font-weight: 500;
        font-size: 28px;
    }

    .button-wrapper{
        width: 100%;
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn:hover{
        border: 1px solid #B08EAD;
    }

    @media screen and (max-width: 700px){
        .product-info{
            flex-direction: column;
        }

        .product-des{
            margin-top: 50px;
        }

        .product-content{
            height: 200px;
        }
    }

    @media screen and (max-width: 460px){
        .container{
            padding: 50px 0px;
        }

        .image-container{
            width: 290px;
            height: 290px;
        }
    }

</style>


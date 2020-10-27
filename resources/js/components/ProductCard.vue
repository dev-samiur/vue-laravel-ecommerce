<template>

    <div class="container" @click="productCardCliked">

        <div class="img-container">
            <img :src="imagePath"/>
        </div>

        <div class="name">{{product.name}}</div>
        <div class="catagory">Catagory: {{product.catagory}}</div>
        <div class="price">Price: {{product.price}}</div>

    </div>

</template>

<script>


export default {
    props:{
        product:{
            required: true,
        },
    },
    data(){
        return{
            imagePath: '/images/'+this.product.image,
        }
    },
    methods:{
        productCardCliked($e){
            this.$emit('productCardCliked', this.product);
            
        }
    }
  
}

</script>

<style scoped>

    .container{
        width: 300px;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        border-bottom: 1px solid #4B3049;
        transition: all 1s;
    }

    .container:hover{
        opacity: .8;
        transform: scale(1.1);
    }

    .img-container{
        width: 100%;
        height: 300px;
        overflow: hidden;
    }

    img{
        width: 300px;
        height: 300px;
        object-fit: cover;
    }

    .name{
        margin-top: 10px;
    }

    .name, .catagory, .price{
        height: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #4B3049;
        font-size: 14px;
        letter-spacing: .05em;
    }

    .price{
        font-weight: 500;
        margin-bottom: 10px;
        color: #B08EAD;
    }

</style>


<template>

    <div class="products-container">

        <div class="header">{{headline}}</div>

        <div class="main-content">

            <div class="grid-item" v-for="product in products" v-bind:key="product.id">
                <ProductCard :product="product" @productCardCliked="productCardCliked"/>
            </div>
            

        </div>

    </div>

</template>

<script>

import ProductCard from './ProductCard.vue';

export default {

    props:{
        changeProductsMargin:{
            type: Boolean,
        },
        products:{
            required: true
        },
        headline:{
            required: true
        }
    },

    components: {
        ProductCard,
    },

    methods: {
        productCardCliked($event){
            this.$emit('showProduct', $event);
        }
    },

    watch: {

        changeProductsMargin: function(newVal, oldVal)
        {

            if(newVal==true)
            {
                if(window.innerWidth>576)
                {
                    let elem= document.querySelector('.products-container');
                    elem.style.marginLeft= "200px";
                }
            }

            else
            {
                if(window.innerWidth>576)
                {
                    let elem= document.querySelector('.products-container');
                    elem.style.marginLeft= "0px";
                }
            }
        }
    }
}

</script>

<style scoped>

    .products-container{
        transition: all 1s;
        min-height: calc(100vh - 60px);
    }

    .header{
        height: 100px;
        font-size: 28px;
        font-weight: 500;
        letter-spacing: .15em;
        line-height: 100px;
        padding-left: 30px;
        color: #4B3049;
    }

    .main-content{
        min-height: calc(100vh - 160px);
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        grid-column-gap: 20px;
        grid-row-gap: 20px;
        padding: 20px;
    }

    .grid-item{
        height: 450px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
  
  
</style>

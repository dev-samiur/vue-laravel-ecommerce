<template>

    <div class="container">

        <SideNav :sideNavStatus="sideNavStatus" @navClicked="navClicked"/>
        <NavBtn @navBtnClicked="showOrHideNav" class="nav-btn" />
        <Products @showProduct="showProduct" :changeProductsMargin="changeProductsMargin" :products="products" :headline="headline"/>

    </div>

</template>

<script>

import SideNav from './SideNav.vue';
import NavBtn from './NavBtn.vue';
import Products from './Products.vue';

export default {
  data(){
      return{
          navBtnClikedCount: 0,
          sideNavStatus: 'hide',
          changeProductsMargin: false,
          productsRetreiveInfo:'all',
          products: {},
          headline: 'ALL'
      }
  },
  components: {
    SideNav,
    NavBtn,
    Products,
  },
  methods: {
      
      showOrHideNav(){

          if(this.navBtnClikedCount==0)
          {
              this.sideNavStatus= 'show';
              this.navBtnClikedCount=1;
              this.changeProductsMargin= true;
          }
          else
          {
              this.sideNavStatus= 'hide';
              this.navBtnClikedCount=0;
              this.changeProductsMargin= false;
          }
      },

      navClicked($event){
          this.productsRetreiveInfo= $event;
          this.headline= $event.toUpperCase();
          this.retrieveProducts();

          if(window.innerWidth<576)
          {
              document.querySelector('.nav-btn').click();
          }
      },

      retrieveProducts(){

          axios({
            method: 'post',
            url: '/api/products',
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

      showProduct($event)
      {
          this.$router.push({
              name: 'show',
              params: {product: $event}
          });
      }
  },

  created(){
      this.retrieveProducts();
  }
}

</script>

<style scoped>

    .container{
        position: relative;
    }
  
  
</style>


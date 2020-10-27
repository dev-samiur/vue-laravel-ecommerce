<template>

        <div class="navbtn hamburger-container" id="navbtn" @click="navBtnClicked">

            <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
            </div>

        </div>

</template>

<script>

export default {
    data(){
        return{
            clickCount: 0
        }
    },
    methods: {
        navBtnClicked(){
            let elem=  document.querySelector('.hamburger')
            if(this.clickCount==0)
            {
                elem.classList.add("open");
                this.clickCount=1;
            }
            else
            {
                elem.classList.remove("open");
                this.clickCount=0;
            }

            this.$emit('navBtnClicked');
        }
    },
    mounted(){
          let elem= document.querySelector('.navbtn');
         
          if(window.innerWidth>1920)
          {
             let docWidth= document.body.clientWidth;
             let docMargin= (docWidth-1920)/2;
             elem.style.left= (1920+docMargin-50)+"px";
          }
         else
         {
             elem.style.left=document.body.clientWidth-50+"px";
         }
        
    }
}

</script>

<style scoped>

    .navbtn{
        position: fixed;
        z-index: 999;
        margin-top: 10px;
        margin-left: -10px;
    }

    .hamburger-container{
        grid-column: 2/3;
        grid-row: 1/2;
        display: flex;
        align-items: flex-end;
        justify-content: flex-end;
    }

    .hamburger{
        width: 35px;
        height: 35px;
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
        -webkit-transition: .5s ease-in-out;
        -moz-transition: .5s ease-in-out;
        -o-transition: .5s ease-in-out;
        transition: .5s ease-in-out;
        cursor: pointer;
        z-index: 999;
    }

    .hamburger span {
    display: block;
    position: absolute;
    height: 6px;
    width: 100%;
    background: #4B3049;
    border-radius: 9px;
    opacity: 1;
    left: 0;
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
    -webkit-transition: .25s ease-in-out;
    -moz-transition: .25s ease-in-out;
    -o-transition: .25s ease-in-out;
    transition: .25s ease-in-out;
    border: 1px solid #F6F6F6;
    }

    .hamburger span:nth-child(1) {
    top: 0px;
    }

    .hamburger span:nth-child(2) {
    top: 12px;
    }

    .hamburger span:nth-child(3) {
    top: 25px;
    }

    .hamburger.open span:nth-child(1) {
    top: 12px;
    -webkit-transform: rotate(135deg);
    -moz-transform: rotate(135deg);
    -o-transform: rotate(135deg);
    transform: rotate(135deg);
    }

    .hamburger.open span:nth-child(2) {
    opacity: 0;
    left: -60px;
    }

    .hamburger.open span:nth-child(3) {
    top: 12px;
    -webkit-transform: rotate(-135deg);
    -moz-transform: rotate(-135deg);
    -o-transform: rotate(-135deg);
    transform: rotate(-135deg);
    }
  
</style>
<template>

        <div class="navbar" :style="navStyle">

            <ul>
                <li class="li-item" @click="navClicked" v-for="catagory in catagories" v-bind:key="catagory">{{catagory}}</li>
            </ul>

        </div>

</template>

<script>

export default {
    props:{
        sideNavStatus:{
            type: String,
            required: true
        }
    },
    data(){
        return {
            catagories:[
                "All", "Balcony", "Bathroom", "Bedroom",  "Chandelier", 
                "Kitchen", "Living Room", "Sofa", 
            ],
        }
    },
    computed: {
        navStyle(){
            if(this.sideNavStatus=='hide')
            {
                if(window.innerWidth>576)
                {
                    return {
                        'margin-left': '-200px',
                        'visibility': 'hidden'
                    }
                }
                else
                {
                    return {
                        'margin-left': '-100%',
                        'visibility': 'hidden'
                    }
                }
            }
            else if(this.sideNavStatus=='show')
            {
                return {
                   'margin-left': '0px',
                   'visibility': 'visible'
                }
            }
        },
    },
    methods: {
        changeActiveState($e){

            let listItems= document.querySelectorAll('.li-item');

            for (let i = 0; i < listItems.length; i++) 
            {
                if(listItems[i].classList.contains('active'))
                {
                    listItems[i].classList.remove('active');
                    break;
                }
            }

             let elem= $e.target;
             elem.classList.add('active');
        },
        navClicked($e){

            this.changeActiveState($e);

            let title=$e.target.innerHTML.toLowerCase();

            this.$emit('navClicked', title);
            
        }
    },
    mounted(){
        document.querySelectorAll('.li-item')[0].classList.add('active');
    }
}

</script>

<style scoped>

    .navbar{
        width: 200px;
        height: calc(100vh - 60px);
        background: #4B3049;
        z-index: 997;
        transition: all 1s;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        visibility: hidden;
    }
    
    ul{
        list-style: none;
        width: 170px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    li{
        width: 100%;
        margin-bottom: 20px;
        border-bottom: 2px solid #B08EAD;
        text-align: center;
        padding-bottom: 10px;
        cursor: pointer;
        transition: all 1s;
        color: #F6F6F6;
        font-size: 15px;
        font-weight: 500;
    }

    li:hover{
        border-bottom: 2px solid #FFF;
    }

    li:last-child{
        margin-bottom: 0px;
    }

    .active{
        border-bottom: 2px solid #FFF;
    }

    @media screen and (max-width: 576px)
    {
       .navbar{
            width: 100%;
       } 
    }

  
</style>
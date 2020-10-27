<template>

    <div class="wrapper" v-show="displayForm">

      <form class="form-contaner" action="" method="" enctype="multipart/form-data">

          <div class="header">

            <span class="brand">Add a new item</span>
            <span @click="hideModal"><img src="/images/cross-btn.png"/></span>

          </div>

          <div class="main-content">

            <BaseInput v-bind:input-details="inputDetails[0]" class="input-field" @keyUpped="setName"/>
            <BaseInput v-bind:input-details="inputDetails[1]" class="input-field" @keyUpped="setPrice"/>

            <div class="catagory-container input-field">
              <span>Catagory: </span>
              <select v-model="inputedData.catagory" id="catagory" name="catagory">

                <option value="balcony">Balcony</option>
                <option value="bathroom">Bathroom</option>
                <option value="bedroom">Bedroom</option>
                <option value="chandelier">Chandelier</option>
                <option value="kitchen">Kitchen</option>
                <option value="living room">Living Room</option>
                <option value="sofa">Sofa</option>

              </select>

            </div>

            <textarea placeholder="Description" v-model="inputedData.description"></textarea>

            <div class="imgup-container input-field">

              <label for="upload-photo">Upload Photo</label>
              <input type="file" name="photo" id="upload-photo" accept="image/*" @change="uploadImage"/>
              <span class="img-name" v-if="photoUploaded">{{inputedData.image.name}}</span>

            </div>

            <BaseButton v-bind:button-details="buttonDetails[0]" v-on:btnClicked="submitClicked" :disabled="isDisabled" class="input-field"/>

          </div>

      </form>
        
    </div>

</template>

<script>

import BaseInput from './BaseInput.vue';
import BaseButton from './BaseButton.vue';

export default {
  name: 'Modal',
  components: {
    BaseInput,
    BaseButton
  },
  props: {
    displayForm: {
          type: Boolean,
          required: true
      }
  },
  data(){
    return {

      inputDetails:[
        {'type':'text','name': 'product name'},
        {'type':'text','name': 'price'},
      ],

      buttonDetails:[
        {'title': 'Submit', 'bg': '#4B3049', 'color': '#FFF', 'hoverBg': '#B08EAD', 'hoverColor':'#4B3049'}
      ],

      inputedData: {
        name: '',
        price: '',
        catagory: '',
        description: '',
        image: '',
      },

    }
  },
  computed: {
    photoUploaded(){
      return (this.inputedData.image != '')
    },

    isDisabled: function()
    {
      if(this.inputedData.name != '' && this.inputedData.price != '' && this.inputedData.catagory != '' && this.inputedData.description != '' && this.inputedData.image != '')
        return false;
      else
        return true;
    }
  },
  methods: {

    hideModal(){
      this.$emit('hideModal');
    },

    uploadImage($event){
      this.inputedData.image= $event.target.files[0];
    },
  
    setName: function($event)
    {
      this.inputedData.name= $event;
    },

    setPrice: function($event)
    {
      this.inputedData.price= $event;
    },

    submitClicked(){
      let data = new FormData();

      data.append('image', this.inputedData.image);
      data.append('name', this.inputedData.name);
      data.append('price', this.inputedData.price);
      data.append('catagory', this.inputedData.catagory);
      data.append('description', this.inputedData.description);

      axios({
        method: 'post',
        url: '/api/addproduct',
        data: data,
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
      })
      .then( response => {

        this.$store.state.ModalData.msg.length=0;
        this.$store.state.ModalData.display= true;

        if(response.data.error)
        {
          if(response.data.error.image)
          {
            this.$store.state.ModalData.msg.push("Image size is too large. Image should be less than 2Mb");
          }

          this.$store.state.ModalData.msg.push(response.data.error);
        }
        else
        {
          location.reload();
        }
        
      });
    },
  }
}

</script>

<style scoped>

    .wrapper{
        width: 100%;
        height: calc(100vh - 60px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: #000;
        position: absolute;
        z-index: 998;
        opacity: .9;
    }

    .form-contaner{
      width: 300px;
      min-height: 200px;
      background: #FFF;
    }

    .header{
      height: 70px;
      background: #4B3049;
      padding: 0px 10px;
    }

    .brand{
      line-height: 70px;
      font-size: 18px;
      color: #FFF;
    }

    .header img{
      width: 25px;
      height: 25px;
      cursor: pointer;
      float: right;
      margin-top: 10px;
    }

    .main-content{
      padding: 10px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .input-field{
      border: 1px solid #4B3049;
      margin-bottom: 10px;
    }

    .catagory-container, .imgup-container{
      width: 250px;
      border: 0px;
      font-size: 14px;
      color: #4B3049;
    }

    select{
      background: #4B3049;
      color: #fff;
      border: 0px;
      min-width: 100px;
      height: 40px;
      font-size: 14px;
      font-weight: 500;
      padding: 5px;
    }

    textarea{
      width: 250px;
      height: 100px;
      font-size: 14px;
      color: #4B3049;
      margin: 10px 0px 20px 0px;
    }

    .imgup-container{
      margin-bottom: 30px;
    }

    label {
      cursor: pointer;
      border: 1px solid #4B3049;
      height: 50px !important;
      display: inline-block;
      padding: 0px 10px;
      line-height: 50px;
      transition: all 2s;
    }

    label:hover{
      background: #4B3049;
      color: #FFF;
    }

    #upload-photo {
      opacity: 0;
      position: absolute;
      z-index: -1;
    }

    .img-name{
      max-width: 100px;
      overflow: hidden;
      display: inline-block;
    }
  
</style>
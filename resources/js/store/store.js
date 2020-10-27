import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store= new Vuex.Store({

    state: {
        ModalData:{
            display: false,
            msg: [
                
            ]
        },
        Orderdata: {
            order: null,
            order_to: null,
        }
    }
})
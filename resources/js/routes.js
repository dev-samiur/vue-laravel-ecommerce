import Home from './components/Home.vue'
import Register from './components/Register.vue'
import Login from './components/Login.vue'
import AdminDashboard from './components/AdminDashboard.vue'
import BuyerDashboard from './components/BuyerDashboard.vue'
import SellerDashboard from './components/SellerDashboard.vue'
import ShowProduct from './components/ShowProduct.vue'

function guardMyroute(to, from, next)
{
    var isAuthenticated= false;

    if(localStorage.getItem('user'))
        isAuthenticated = true;
    else
        isAuthenticated= false;

    if(isAuthenticated) 
    {
        next(); 
    } 
    else
    {
        next('/login'); 
    }
}

export default [
    {
        path: '/',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        component: Register
    },
    {
        path: '/dashboard/1',
        beforeEnter : guardMyroute,
        component: AdminDashboard
    },
    {
        path: '/dashboard/2',
        beforeEnter : guardMyroute,
        component: BuyerDashboard
    },
    {
        path: '/dashboard/3',
        beforeEnter : guardMyroute,
        component: SellerDashboard
    },

    {
        path: '/show',
        component: ShowProduct,
        name: "show",
    }
]
import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'



console.log(stockMan);
const router = createRouter({
    history: createWebHashHistory('wp-content/plugins/stock-managment/build/js'),
    routes: [{
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/about',
            name: 'about',
            // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () =>
                import ('../views/AboutView.vue')
        },
        {
            path: '/locations',
            name: 'locations',
            component: () =>
                import ('../views/location/LocationHomeView.vue')
        }
    ]
})

export default router
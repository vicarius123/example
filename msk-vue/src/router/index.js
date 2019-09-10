import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/components/Index'
import Profile from '@/components/Profile'
import Messages from '@/components/Chat'
import Task from '@/components/Task'
import Singup from '@/components/auth/signup'
import Login from '@/components/auth/login'
import firebase from 'firebase'
import InnerChat from '@/components/InnerChat.vue'

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'Index',
      component: Index,
      meta:{
        requiredAuth: true
      },
      children:[
        {
          path:'profile',
          component: Profile,
          name:'Profile'
        },
        {
          path:'task',
          component: Task,
          name: 'Task'
        },
        {
          path:'messages/',
          component: Messages,
          name:'Messages',
          children:[
            {
              path : ':user_id/',
              component:InnerChat,
              name:'InnerChat',
              props: true
            }
          ]
        }
      ]
    },
    {
      path: '/singup',
      name: 'Singup',
      component: Singup,
    },
    {
      path: '/login',
      name: 'Login',
      component: Login,
    }
  ]
})

router.beforeEach((to, from, next)=>{
  //check auth
  if(to.matched.some(rec => rec.meta.requiredAuth)){
    //check user auth state
    firebase.auth().onAuthStateChanged((user)=>{
      if(user){
        next()
      }else{
        next({name:'Login'})
      }
    })
  }else{
    next()
  }
})

export default router

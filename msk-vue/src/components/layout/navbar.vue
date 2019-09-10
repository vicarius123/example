<template lang="html">
  <header>
    <div class="navbar">
      <nav class='indigo'>
        <div class="container nav-wrapper">
          <a href="" class="brand-logo left"></a>
          <ul class="right">
            <li v-if="!user">
              <router-link :to="{ name: 'Singup'}">Singup</router-link>
            </li>
            <li v-if="!user">
              <router-link :to="{ name: 'Login'}">Login</router-link>
            </li>
            <li v-if="user">
              <a href="" @click="logout">Logout</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>
</template>

<script>
import firebase from 'firebase'

export default {
  name: 'Navbar',
  data(){
    return{
      user:null
    }
  },
  methods:{
    logout(){
      firebase.auth().signOut().then(()=>{
        this.$router.push({name:'Login'})
      })
    }
  },
  created(){
    //let user = firebase.auth().currentUser
    firebase.auth().onAuthStateChanged((user)=>{
      if(user){
        this.user = user
      }else{
        this.user = null
      }
    })
  }
}
</script>

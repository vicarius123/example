<template>
  <div class="">
    <ul id="slide-out" class="sidenav sidenav-fixed">
      <li>
        <div class="user-view">

          <span class="name" v-if="user">{{user.displayName}}</span>
          <span class="email" v-if="user">{{user.email}}</span>
        </div>
      </li>

      <leftBar />
    </ul>
    <main>
      <div>
        <router-view/>
      </div>
    </main>
  </div>
</template>

<script>
import leftBar from '@/components/layout/leftBar'
import db from '@/firebase/init'
import firebase from 'firebase'


export default {
  name: 'Index',
  components:{leftBar},
  data () {
    return {
      user:null
    }
  },
  created(){
    firebase.auth().onAuthStateChanged((usr)=>{
      this.user = firebase.auth().currentUser
    })
  },
  watch:{
    user(val){
      this.user = val
    }
  }

}
</script>

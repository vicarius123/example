<template lang="html">
  <div class="">

    <div class="row">
      <div class="col s3">
        <ul class="collection">
          <li v-for="user in users" v-if="me != user.id" class="">
            <router-link class="collection-item" :class="{'active': user.id==currentUser}" :to="{ name: 'InnerChat', params: {user_id : user.id} }">
              <span class="new badge blue"></span>{{user.name}}
            </router-link>
          </li>
        </ul>
      </div>
      <div class="col s9">
        <router-view @updateLink="newLink"/>
      </div>
    </div>
  </div>
</template>

<script>
import db from '@/firebase/init'
import firebase from 'firebase'

export default {
  name:'Messages',
  data(){
    return{
      users:[],
      me:null,
      currentUser:null,
    }
  },
  methods:{
    newLink(e){
      this.currentUser = e
    },
  },
  created(){
    this.currentUser = this.$router.currentRoute.params.user_id
    let ref = db.collection('users')
    ref.onSnapshot(snapshot=>{
      snapshot.docChanges().forEach(change=>{
        if(change.type == 'added'){
          let doc = change.doc
          this.users.push({
            id:doc.id,
            company: doc.data().company,
            name: doc.data().name,
            phone: doc.data().phone
          })
        }
      })
    })
    firebase.auth().onAuthStateChanged((user)=>{
      if(user){
        this.me = user.uid
      }
    })
  }
}
</script>

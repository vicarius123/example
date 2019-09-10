<template lang="html">
  <div class="">
    <div class="row">
      <div class="col s6">
        <div class="card">
          <form @submit.prevent="update">
            <div class="card-content">
              <div class="field">
                <label for="fio">ФИО:</label>
                <input type="text" name="fio" v-model="fio">
              </div>
              <div class="field">
                <label for="email">Email:</label>
                <input type="text" name="email" v-model="email">
              </div>
              <div class="field">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" v-model="phone">
              </div>
              <div class="field">
                <label for="company">Company:</label>
                <input type="text" name="company" v-model="company">
              </div>
              <div class="field red-text">
                {{this.feedback}}
              </div>
            </div>
            <div class="card-action center-align">
              <button class="btn blue">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import db from '@/firebase/init'
import firebase from 'firebase'

export default {
  name:'Profile',
  data(){
    return{
      fio:null,
      email:null,
      feedback:null,
      phone:null,
      company: null
    }
  },
  methods:{
    update(){

      firebase.auth().onAuthStateChanged((user)=>{
        if(user){
          user.updateProfile({
            displayName:this.fio,
            email: this.email,
          }).then(()=>{
            //saving phone and etc
            let ref = db.collection('users').doc(user.uid)
            ref.get().then(doc => {
              if(doc.exists){
                ref.set({
                  company: this.company,
                  name: this.fio,
                  phone: this.phone
                })
                this.feedback = 'Success'
              }
            })
          }).catch((err)=>{
            this.feedback = err
          })
        }
      })
    }
  },
  created(){
    var vm = this
    firebase.auth().onAuthStateChanged((user)=>{
      console.log(user)
      if(user){
        this.email = user.email
        this.fio = user.displayName

        let ref = db.collection('users').doc(user.uid)
        ref.get().then(doc => {
          if(doc.exists){
            this.company = doc.data().company
            this.phone = doc.data().phone
          }
        })
      }
    })
  }
}
</script>

<template lang="html">
  <div class="singup container">
    <div class="row">
      <div class="col offset-s3 s6">
        <form @submit.prevent="singup" class="card-panel">
          <h3 class="center">Singup</h3>
          <div class="field">
            <label for="fio">ФИО:</label>
            <input type="text" name="fio" v-model="fio">
          </div>
          <div class="field">
            <label for="email">Email:</label>
            <input type="email" name="email" v-model="email">
          </div>
          <div class="field">
            <label for="password">Password:</label>
            <input type="password" name="password" v-model="password">
          </div>
          <div class="field red-text">
            {{this.feedback}}
          </div>
          <div class="field center">
            <button class="btn blue">Singup</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import db from '@/firebase/init'
import firebase from 'firebase'

export default {
  name: 'Singup',
  data(){
    return{
      email:null,
      password:null,
      fio:null,
      feedback:null,
    }
  },
  methods:{
    singup(){
      if(this.email && this.password && this.fio){

        firebase.auth().createUserWithEmailAndPassword(this.email, this.password)
        .then(cred=>{
          console.log(cred)
          let ref = db.collection('users').doc(cred.user.uid)
          ref.get().then(doc => {
            if(!doc.exists){
              ref.set({
                user_id: cred.user.uid,
                name: this.fio
              })
              this.$router.push('/')
            }else{
              this.$router.push('/')
            }
          })
        })
        .catch(err=>{
          console.log(err)
          this.feedback = err.message
        })
      }else{
        this.feedback = "Fill everything"
      }
    }
  }
}
</script>

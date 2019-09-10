<template lang="html">
  <div class="login__ctn">
    <div class="container">
      <div class="row">
        <div class="col offset-s3 s6">
          <form @submit.prevent="login" class="card-panel">
            <h3 class="center">Login</h3>
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
              <button class="btn blue">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import firebase from 'firebase'
export default {
  name:'login',
  data(){
    return{
      feedback:null,
      email:null,
      password:null
    }
  },
  methods:{
    login(){
      if(this.email && this.password){
        this.feedback = null

        firebase.auth().signInWithEmailAndPassword(this.email, this.password)
        .then(cred =>{
          this.$router.push({name:'Index'})
        })
        .catch(err=>{
          console.log(err)
          this.feedback = err.message
        })

      }else{
        this.feedback='Write login and password'
      }
    }
  }
}
</script>

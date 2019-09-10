<template lang="html">
  <div class="card ">
    <div class="card-content chat__window" v-chat-scroll>
      <div v-for="msg in messages" class="each__chat" :class="{'from__me': msg.from==user.uid}">
        <div class="z-depth-2 " :class="{'blue white-text': msg.from==user.uid}">
          <p>{{msg.text}}</p>
        </div>
        <small>{{msg.timestamp}}</small>
      </div>
      <br clear="all">
    </div>
    <div class="card-action">
      <form @submit.prevent="addMessage" class="input-field">
        <div class="row">
          <div class="col s10">
            <input id="" type="text" v-model="message">
          </div>
          <div class="col pull">
            <button class="btn blue">Send</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import db from '@/firebase/init'
import firebase from 'firebase'
import moment from 'moment'
moment.locale('ru')

//Listener reset
let ref = function(){}

export default {
  name:'InnerChat',
  props: ['user_id'],
  data(){
    return{
      messages:[],
      message:null,
      from: null,
      msgNode:null,
      user:null,
      each__chat:'each__chat'
    }
  },
  methods:{
    addMessage(){
      let user = firebase.auth().currentUser
      if(user){
        if(this.message){
          let ref = db.collection('messages').doc(this.msgNode).collection('message')
          ref.get().then(doc => {
            ref.add({
              from: user.uid,
              to:this.user_id,
              text:this.message,
              timestamp: Date.now()
            })
            this.message = null
          })
        }
      }
    },
  },
  created(){
    this.user = firebase.auth().currentUser
    let user = firebase.auth().currentUser
    this.from = user.uid
    if(this.user_id < this.from){
      this.msgNode = this.user_id+this.from
    }else{
      this.msgNode = this.from+this.user_id
    }
  },
  watch:{
    user_id(val){
      let user = firebase.auth().currentUser

      this.user_id = val
      if(this.user_id < user.uid){
        this.msgNode = this.user_id+user.uid
      }else{
        this.msgNode = user.uid+this.user_id
      }

      this.$emit('updateLink', this.user_id)

    },
    msgNode(val){
      this.msgNode = val
      //reset the Listener
      ref()
      this.messages = []
      ref = db.collection('messages').doc(this.msgNode).collection('message').orderBy('timestamp')
      .onSnapshot(snapshot=>{
        snapshot.docChanges().forEach(change=>{
          if(change.type == 'added'){
            let doc = change.doc
            this.messages.push({
              id: doc.id,
              from: doc.data().from,
              text: doc.data().text,
              to: doc.data().to,
              timestamp: moment(doc.data().timestamp).calendar()
            })
          }
        })
      })
    }
  }
}
</script>

<template lang="html">
  <div class="">
    <div class="collection">
      <router-link :to="{ name: 'Task'}" class="collection-item">Tasks</router-link>
      <router-link :to="{ name: 'Messages'}" class="collection-item">Messages</router-link>
      <router-link :to="{ name: 'Profile'}" class="collection-item">Settings</router-link>
    </div>
  </div>
</template>

<script>
export default {
  name:'leftBar',
  data(){
    return{

    }
  }
}
</script>

<template>
  <div id="app">
    <Navbar />
    <router-view/>
  </div>
</template>

<script>

import Navbar from '@/components/layout/navbar'

export default {
  name: 'App',
  components:{
    Navbar
  }
}
</script>

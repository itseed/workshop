<template>
  <div>
    <Header />
    <div style="margin-top: 60px;">
      <Nuxt />
    </div>
  </div>
</template>

<script>
export default {
  mounted(){
    if(!this.$auth.loggedIn){
      this.$router.push('/admin')
    }
  }
}
</script>

<style>
  body {
    font-family: 'Prompt', sans-serif;
  }
</style>
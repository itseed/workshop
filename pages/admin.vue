<template>
  <b-container fluid class="p-4 w-75">
    <b-row align-h="center">
      <b-col sm="12" md="12" lg="6" xl="4">
        <h3 class="title" style="text-align: center;">Login</h3>
        <hr>
        <Notification :message="error" v-if="error"/>
        <b-form @submit.prevent="login">
          <b-form-group id="input-group-1" label-for="input-1">
            <b-form-input id="input-1" type="text" v-model="email" :state="inputState.email" placeholder="Username" />
          </b-form-group>
          
          <b-form-group id="input-group-2" label-for="input-2">
            <b-form-input id="input-2" type="password" v-model="password" :state="inputState.password" placeholder="Password" />
          </b-form-group>

          <center>
            <b-button type="submit" variant="primary">Login</b-button>
            <b-button type="reset">Reset</b-button>
          </center>
        </b-form>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  layout: 'auth',
  data(){
    return {
      email: '',
      password: '',
      inputState: {
        email: null,
        password: null,
      },
      error: null
    }
  },
  methods: {
    async login() {
      try {
        await this.$auth.loginWith('local', {
          data: {
          email: this.email,
          password: this.password
          }
        })

        this.$router.push('/dashboard')
      } catch (e) {
        this.error = e.response.data.message
      }
    }
  },
  mounted(){
    if(this.$auth.loggedIn){
      this.$router.push('/dashboard')
    }
  }
}
</script>
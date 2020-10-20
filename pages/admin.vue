<template>
  <b-container fluid class="p-4 w-75">
    <b-row align-h="center">
      <b-col sm="12" md="12" lg="6" xl="4">
        <h3 class="title" style="text-align: center;">Authentication</h3>
        <hr>
        <b-form @submit="login">
          <b-form-group id="input-group-1" label-for="input-1">
            <b-form-input id="input-1" type="text" v-model="username" :state="inputState.username" placeholder="Username" />
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
      username: '',
      password: '',
      inputState: {
        username: null,
        password: null,
      }
    }
  },
  methods: {
    async login(e) {
      console.log('submit form');
      e.preventDefault();
      const payload = {
        username: this.username,
        password: this.password
      };

      console.log(payload)

      try {
        await this.$auth.loginWith('local', {
          data: payload
        });
        this.$router.push('/dashboard');
      } catch (e) {
        this.$router.push('/admin');
      }
    }
  },
  mounted(){
    console.log('Auth', this.$auth.loggedInUser)
  }
}
</script>
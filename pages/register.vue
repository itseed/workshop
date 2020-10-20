<template>
  <b-container fluid class="p-4 w-75">
    <b-row align-h="center">
      <b-col sm="12" md="12" lg="6" xl="6">
        <h3 class="title" style="text-align: center;">Register Page</h3>
        <hr>
        <div v-if="registerStatus">
          <center>
            <b-icon icon="check-circle" variant="success" style="width: 120px; height: 120px;"></b-icon>
            <h5>Register Success</h5>
            <b-button type="button" @click="onClose">Close</b-button>
          </center>
        </div>
        <div v-else>
          <center>
            <div v-if="profile.pictureUrl">
              <b-avatar :src="profile.pictureUrl" size="6rem"></b-avatar>
            </div>
            <div v-else>
              <b-avatar size="6rem"></b-avatar>
            </div>
          </center>
          <b>userId:</b> {{profile.userId}}<br>
          <b>displayName:</b> {{profile.displayName}}<br>
          <b>statusMessage:</b> {{profile.statusMessage}}<br>
          <hr>
          <b-form @submit.prevent="register">
            <b-form-group id="input-group-1" label-for="input-1">
              <b-form-input id="input-1" type="text" v-model="fullname" :state="inputState.fullname" placeholder="Your name" />
            </b-form-group>
            
            <b-form-group id="input-group-2" label-for="input-2">
              <b-form-input id="input-2" type="text" v-model="email" :state="inputState.email" placeholder="Your email" />
            </b-form-group>

            <b-form-group id="input-group-3" label-for="input-2">
              <b-form-input id="input-3" type="text" v-model="phonenumber" :state="inputState.phonenumber" placeholder="Your mobile phone number" />
            </b-form-group>
            <center>
              <b-button type="submit" variant="primary">Register</b-button>
              <b-button type="reset">Reset</b-button>
            </center>
          </b-form>
        </div>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
const liffId = process.env.LIFF_ID

export default {
  data(){
    return {
      fullname: '',
      email: '',
      phonenumber: '',
      profile: {
        userId: '',
        displayName: '',
        pictureUrl: '',
        statusMessage: ''
      },
      inputState: {
        fullname: null,
        email: null,
        phonenumber: null,
      },
      registerStatus: false
    }
  },
  mounted() {
    if (location.hostname !== "localhost") {
      liff.init({ liffId })
      .then(() => {
        // Start to use liff's api
        if (liff.isLoggedIn()) {
          let _this = this
          liff.getProfile().then(function (profile) {
            console.log(profile)
            _this.profile = profile
            _this.checkData()
          }).catch(function (error) {
            console.log('Error getting profile: ' + error)
          })
        } else {
          liff.login({ redirectUri: process.env.BASE_URL+"/register" });
        }
      })
      .catch((err) => {
        // Error happens during initialization
        console.log(err.code, err.message);
      });
    }else{
      const profile = {
        userId: 'Ub9374202f3434a5bf688d1d67c9c6acd',
        displayName: 'chaykr (E25AYL)',
        pictureUrl: 'https://profile.line-scdn.net/0hysnBIggPJlxTOw4lwl1ZC29-KDEkFSAUKwluaCU7eGV3WTUOa109bSVrcDx2DWJdZlo-byE8L252',
        statusMessage: 'Aim for success, not perfection. Never give up your right to be wrong, because then you will lose the ability to learn new things and move forward with your life.- Dr. David M. Burns'
      }

      let _this = this
      _this.profile = profile
      _this.checkData()
    }
  },
  methods: {
    async checkData(){
      //console.log(this.profile)
      const profile = this.profile
      const result = await this.$axios.$get('api/verify/'+profile.userId)
      console.log('result ', result.data.status)
      if(result.data.status){
        this.registerStatus = true
      }
    },

    async register() {
      let _this = this
      const profile = this.profile

      // const result = await this.$axios.$post('api/verify/')
      this.$axios.$post('api/register', {
        fullname: this.fullname,
        phone_number: this.phonenumber,
        email: this.email,
        uid: profile.userId,
        displayName: profile.displayName,
        pictureUrl: profile.pictureUrl,
        statusMessage: profile.statusMessage
      }).then(response => {
        // If request is good...
        console.log(response.status);
        if(response.status === 'success'){
          _this.registerStatus = true
        }
      })
      .catch((error) => {
        console.log('error 3 ' + error);
      });
    },

    onClose(){
      if (location.hostname !== "localhost") {
        liff.closeWindow()
      }
    }
  }
}
</script>
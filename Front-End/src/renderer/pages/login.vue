<template>
  <div id="app">

    <div class="uk-section uk-section-muted uk-flex uk-flex-middle uk-animation-fade" uk-height-viewport>
      <div class="uk-width-1-1">
        <div class="uk-container">
          <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
            <div class="uk-width-1-1@m">
              <div class="uk-margin uk-width-large uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-large">
                <h3 class="uk-card-title uk-text-center font-weight-bold">Aqua Mobile</h3>
                <p class="uk-card-title uk-text-center">Welcome back!</p>
                <form>
                  <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                      <span class="uk-form-icon" uk-icon="icon: mail"></span>
                      <input class="uk-input uk-form-large" type="text" placeholder="Username"
                             id="userName" required v-model="loginDetails.userName">
                    </div>
                  </div>
                  <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                      <span class="uk-form-icon" uk-icon="icon: lock"></span>
                      <input class="uk-input uk-form-large" type="password" placeholder="Password"
                      id="password" required v-model="loginDetails.password">
                    </div>
                  </div>

                  <p id="error-message" style="color: red!important;font-weight: bold;display: none">Username or password is incorrect, Try Again!!</p>
                  <div class="uk-margin">
                    <button class="uk-button uk-button-primary uk-button-large uk-width-1-1" @click="userLogin">Login</button>
                  </div>
                  <div class="uk-text-small uk-text-center f-p" style="display:none;">
                    Forgot password? <a href="#">click here</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import router from '../router'
  import axios from 'axios'
    export default {

      data(){
        return{
          loginDetails:{
            userName:null,
            password:null,
          },
          loggedSession:{
            status:0,
            name:""
          },
        }
      },

      methods:{
        async userLogin(){

          if(this.loginDetails.userName  && this.loginDetails.password)
          {

            await axios.post("http://localhost:8000/api/login",this.loginDetails,{
              headers:{
                "token":this.$token
              }
            })
            .then(response=>{
              this.loggedSession.name = response.data.loggedUser.name;
              this.loggedSession.status = response.data.loggedUser.status;
            })
            this.$session.start();
            this.$session.set('name', this.loggedSession.name);
            if (this.loggedSession.status === 1) {
              this.$session.set('user', 1);
              router.push('/dashboard');
            } else if (this.loggedSession.status === 2) {
              this.$session.set('user', 2);
              router.push('/dashboard');
            } else {
              document.getElementById("error-message").style.display = "block";
            }
          }else{
            alert("Username or password cannot be empty!!")
          }

        }
      },

      beforeMount() {
        this.loggedSession.name ="";
        this.loggedSession.status  = 0;
        this.$session.destroy();
      },

      beforeCreate() {
        this.$session.destroy();
      }

    }
</script>

<style scoped>

  .uk-section{
    background-image: url("../../../static/images/huawei_logo.png")!important;

  }

  .uk-section h3,.uk-section p,.f-p{
    color: #ffffff!important;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
  }

  .uk-card{
    background: rgba(0, 0, 0, 0.5)!important;

  }
</style>

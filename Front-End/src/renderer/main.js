import Vue from 'vue'
import axios from 'axios'
import '../plugins/bootstrap-vue'
import App from './App'
import router from './router'
import store from './store'
import VueSession from 'vue-session'
import CKEditor from '@ckeditor/ckeditor5-vue'
import VueBarcodeScanner from 'vue-barcode-scanner'

let barcodeOptions = {
  sound: true,
  soundSrc:'/static/sound/pos_beep.wav',
  sensitivity: 50,
  requiredAttr: true,
  controlSequenceKeys: ['NumLock', 'Clear'],
  callbackAfterTimeout: true,
}



Vue.use(VueBarcodeScanner,barcodeOptions)
Vue.use(VueSession)


Vue.prototype.$token = " "; //Place your token here

if (!process.env.IS_WEB) Vue.use(require('vue-electron'))
Vue.http = Vue.prototype.$http = axios
Vue.config.productionTip = false

Vue.use(CKEditor)

/* eslint-disable no-new */

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

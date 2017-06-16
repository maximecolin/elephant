import VueApollo from 'vue-apollo'
import Vue from 'vue'
import App from './App'
import apollo from './apollo'
import router from './router'
import store from './store'

Vue.config.productionTip = false

// Apollo config

Vue.use(VueApollo, {
  apollo
})

const apolloProvider = new VueApollo({
  defaultClient: apollo
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  apolloProvider,
  render: h => h(App)
})

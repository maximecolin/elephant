import ApolloClient, { createNetworkInterface } from 'apollo-client'
import VueApollo from 'vue-apollo'
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'

Vue.config.productionTip = false

// Apollo config
const apolloClient = new ApolloClient({
  networkInterface: createNetworkInterface({
    uri: 'http://server.elephant.dev/graphql/',
    transportBatching: true
    // opts: {
    //   headers: {
    //     key: 'SecretKey',
    //   },
    // },
  })
})

Vue.use(VueApollo, {
  apolloClient
})

const apolloProvider = new VueApollo({
  defaultClient: apolloClient
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  apolloProvider,
  render: h => h(App)
})

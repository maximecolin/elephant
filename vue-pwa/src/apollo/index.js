import ApolloClient, { createNetworkInterface } from 'apollo-client'

// Apollo config
const client = new ApolloClient({
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

export default client

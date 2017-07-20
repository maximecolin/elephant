import ApolloClient, { createNetworkInterface } from 'apollo-client'

// Apollo config
const client = new ApolloClient({
  networkInterface: createNetworkInterface({
    uri: 'http://server.elephant.dev/graphql/',
    transportBatching: true,
    dataIdFromObject: object => object.id,
    opts: {
      headers: {
        Authorization: 'Bearer DyJcQ8QDdAajUzerHANaXrsHPzuD9pppHpbVNtXJQ9nXutMgKirkEyY2RadEdGCC',
      },
    },
  })
})

export default client

import Vue from 'vue'
import Vuex from 'vuex'
import NewCollectionMutation from '../graphql/NewCollectionMutation'
import CollectionsQuery from '../graphql/CollectionsQuery'
import apollo from '../apollo'

Vue.use(Vuex)

// @see https://github.com/PierBover/vuex-apollo-example-project/blob/master/store.js
// @see https://github.com/Akryum/vue-apollo/issues/7
// @see https://github.com/Akryum/vue-apollo#mutations
// @see https://github.com/vuejs/vue-curated-client/tree/dev/src
// @see https://github.com/Akryum/vue-apollo/issues/7#issuecomment-278657787
// @see https://github.com/vuejs/vuex/blob/dev/examples/shopping-cart/store/modules/cart.js

export default new Vuex.Store({
  state: {
    modal: {
      addBookmark: false,
      addCollection: false
    },
    collections: {
      edges: []
    }
  },
  mutations: {
    OPEN_ADD_BOOKMARK_MODAL (state) {
      state.modal.addBookmark = true
    },
    CLOSE_ADD_BOOKMARK_MODAL (state) {
      state.modal.addBookmark = false
    },
    OPEN_ADD_COLLECTION_MODAL (state) {
      state.modal.addCollection = true
    },
    CLOSE_ADD_COLLECTION_MODAL (state) {
      state.modal.addCollection = false
    },
    SET_COLLECTIONS (state, collections) {
      // having an object instead of an array makes the other methods easier
      // since we can use Vue.set() and Vue.delete()
      const object = {}
      collections.edges.map((collection) => { object[collection.id] = collection })
      state.collections.edges = object
    },
    ADD_COLLECTION (state, collection) {
      Vue.set(state.collections.edges, collection.id, collection)
    }
  },
  actions: {
    INIT (context) {
      apollo.query({
        query: CollectionsQuery
      }).then((result) => {
        context.commit('SET_COLLECTIONS', result.data.collections)
      })
    },
    ADD_COLLECTION ({ commit, state }, collection) {
      apollo.mutate({
        mutation: NewCollectionMutation,
        variables: {
          title: collection.title
        }
      }).then((result) => {
        commit('ADD_COLLECTION', result.data.collection)
        commit('CLOSE_ADD_COLLECTION_MODAL')
      })
    }
  }
})

import Vue from 'vue'
import Vuex from 'vuex'
import CollectionsQuery from '../graphql/CollectionsQuery'
import apollo from '../apollo'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    modal: {
      addBookmark: false,
      addCollection: false
    },
    collections: []
  },
  mutations: {
    openAddBookmarkModal (state) {
      state.modal.addBookmark = true
    },
    closeAddBookmarkModal (state) {
      state.modal.addBookmark = false
    },
    openAddCollectionModal (state) {
      state.modal.addCollection = true
    },
    closeAddCollectionModal (state) {
      state.modal.addCollection = false
    },
    SET_COLLECTIONS (state, collections) {
      state.collections = collections
    }
  },
  actions: {
    init (context) {
      apollo.query({
        query: CollectionsQuery
      }).then((result) => {
        context.commit('SET_COLLECTIONS', result.data.collections)
      })
    },
    }
  }
})

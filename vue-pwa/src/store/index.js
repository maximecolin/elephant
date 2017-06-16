import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    modal: {
      addBookmark: false,
      addCollection: false
    }
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
    }
  }
})

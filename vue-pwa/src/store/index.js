import Vue from 'vue'
import Vuex from 'vuex'
import NewCollectionMutation from '../graphql/NewCollectionMutation'
import NewBookmarkMutation from '../graphql/NewBookmarkMutation'
import CollectionsQuery from '../graphql/CollectionsQuery'
import CollectionQuery from '../graphql/CollectionQuery'
import apollo from '../apollo'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    modal: {
      addBookmark: false,
      addCollection: false
    },
    collections: {},
    bookmarks: {}
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
      collections.edges.map((collection) => {
        object[collection.id] = {
          id: collection.id,
          title: collection.title,
          bookmarks: collection.bookmarks.total
        }
      })
      state.collections = object
    },
    ADD_COLLECTION (state, collection) {
      Vue.set(state.collections, collection.id, {
        id: collection.id,
        title: collection.title,
        bookmarks: collection.bookmarks.total
      })
    },
    ADD_BOOKMARK (state, payload) {
      state.collections[payload.collectionId].bookmarks++
      Vue.set(state.bookmarks[payload.collectionId], payload.bookmark.id, payload.bookmark)
    },
    SET_BOOKMARKS (state, payload) {
      // having an object instead of an array makes the other methods easier
      // since we can use Vue.set() and Vue.delete()
      const object = {}
      payload.bookmarks.map((bookmark) => { object[bookmark.id] = bookmark })
      Vue.set(state.bookmarks, payload.collectionId, object)
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
    GET_COLLECTION (context, id) {
      apollo.query({
        query: CollectionQuery,
        variables: {
          id,
          offset: 0,
          limit: 100
        }
      }).then((result) => {
        context.commit('ADD_COLLECTION', result.data.collection)
        context.commit('SET_BOOKMARKS', { collectionId: id, bookmarks: result.data.collection.bookmarks.edges })
      })
    },
    ADD_COLLECTION (context, collection) {
      apollo.mutate({
        mutation: NewCollectionMutation,
        variables: {
          title: collection.title
        }
      }).then((result) => {
        context.commit('ADD_COLLECTION', result.data.collection)
        context.commit('CLOSE_ADD_COLLECTION_MODAL')
      })
    },
    ADD_BOOKMARK (context, bookmark) {
      apollo.mutate({
        mutation: NewBookmarkMutation,
        variables: {
          title: bookmark.title,
          url: bookmark.url,
          collectionId: bookmark.collectionId
        }
      }).then((result) => {
        context.commit('ADD_BOOKMARK', { collectionId: bookmark.collectionId, bookmark: result.data.bookmark })
        context.commit('CLOSE_ADD_BOOKMARK_MODAL')
      })
    }
  }
})

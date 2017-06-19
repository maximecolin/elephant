import Vue from 'vue'
import Vuex from 'vuex'
import NewCollectionMutation from '../graphql/NewCollectionMutation'
import NewBookmarkMutation from '../graphql/NewBookmarkMutation'
import RemoveBookmarkMutation from '../graphql/RemoveBookmarkMutation'
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
      Vue.set(state.bookmarks[payload.collectionId], payload.bookmark.id, payload.bookmark)
      state.collections[payload.collectionId].bookmarks++
    },
    REMOVE_BOOKMARK (state, payload) {
      Vue.delete(state.bookmarks[payload.collectionId], payload.bookmark.id)
      state.collections[payload.collectionId].bookmarks--
    },
    SET_BOOKMARKS (state, payload) {
      // having an object instead of an array makes the other methods easier
      // since we can use Vue.set() and Vue.delete()
      const object = {}
      payload.bookmarks.map((bookmark) => {
        object[bookmark.id] = {
          id: bookmark.id,
          title: bookmark.title,
          url: bookmark.url
        }
      })
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
    ADD_BOOKMARK (context, payload) {
      apollo.mutate({
        mutation: NewBookmarkMutation,
        variables: {
          title: payload.title,
          url: payload.url,
          collectionId: payload.collectionId
        }
      }).then((result) => {
        context.commit('ADD_BOOKMARK', { collectionId: payload.collectionId, bookmark: result.data.bookmark })
        context.commit('CLOSE_ADD_BOOKMARK_MODAL')
      })
    },
    REMOVE_BOOKMARK (context, payload) {
      apollo.mutate({
        mutation: RemoveBookmarkMutation,
        variables: {
          id: payload.bookmark.id
        }
      }).then((result) => {
        if (result.data.removeBookmark === true) {
          context.commit('REMOVE_BOOKMARK', { collectionId: payload.collectionId, bookmark: payload.bookmark })
        }
      })
    }
  }
})

import Vue from 'vue'
import Vuex from 'vuex'
import NewCollectionMutation from '../graphql/NewCollectionMutation'
import UpdateCollectionMutation from '../graphql/UpdateCollectionMutation'
import RemoveCollectionMutation from '../graphql/RemoveCollectionMutation'
import NewBookmarkMutation from '../graphql/NewBookmarkMutation'
import UpdateBookmarkMutation from '../graphql/UpdateBookmarkMutation'
import RemoveBookmarkMutation from '../graphql/RemoveBookmarkMutation'
import CollectionsQuery from '../graphql/CollectionsQuery'
import CollectionQuery from '../graphql/CollectionQuery'
import apollo from '../apollo'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    ready: false,
    modal: {
      addBookmark: false,
      addCollection: false
    },
    collections: {},
    bookmarks: {},
    alerts: []
  },
  mutations: {
    MARK_AS_READY (state) {
      setTimeout(() => { state.ready = true }, 2000)
    },
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
    REMOVE_COLLECTION (state, collection) {
      Vue.delete(state.collections, collection.id)
      Vue.delete(state.bookmarks, collection.id)
    },
    ADD_BOOKMARK (state, { bookmark, collectionId }) {
      // Don't update bookmarks list if it has not been fetched yet
      // List will be populate by GET_COLLECTION
      if (state.bookmarks[collectionId] !== undefined) {
        Vue.set(state.bookmarks[collectionId], bookmark.id, bookmark)
      }

      state.collections[collectionId].bookmarks++
    },
    REMOVE_BOOKMARK (state, { bookmark, collectionId }) {
      Vue.delete(state.bookmarks[collectionId], bookmark.id)
      state.collections[collectionId].bookmarks--
    },
    SET_BOOKMARKS (state, { bookmarks, collectionId }) {
      // having an object instead of an array makes the other methods easier
      // since we can use Vue.set() and Vue.delete()
      const object = {}
      bookmarks.map((bookmark) => {
        object[bookmark.id] = {
          id: bookmark.id,
          title: bookmark.title,
          url: bookmark.url,
          collectionId: collectionId
        }
      })
      Vue.set(state.bookmarks, collectionId, object)
    },
    ADD_ALERT (state, alert) {
      state.alerts.push(alert)
    },
    REMOVE_ALERT (state, alert) {
      const index = state.alerts.indexOf(alert)
      if (index >= 0) {
        state.alerts[index].show = false
        setTimeout(() => { state.alerts.splice(state.alerts.indexOf(alert), 1) }, 400)
      }
    }
  },
  actions: {
    INIT (context) {
      apollo.query({
        query: CollectionsQuery
      }).then((result) => {
        context.commit('SET_COLLECTIONS', result.data.collections)
        context.commit('MARK_AS_READY')
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
        context.commit('ADD_COLLECTION', result.data.createCollection)
        context.commit('CLOSE_ADD_COLLECTION_MODAL')
        context.dispatch('ADD_ALERT', { type: 'inverse', message: 'Votre collection a été ajoutée', show: true })
      })
    },
    UPDATE_COLLECTION (context, collection) {
      apollo.mutate({
        mutation: UpdateCollectionMutation,
        variables: {
          id: collection.id,
          title: collection.title
        }
      }).then((result) => {
        context.commit('ADD_COLLECTION', result.data.updateCollection)
        context.dispatch('ADD_ALERT', { type: 'inverse', message: 'La collection a été mise à jour', show: true })
      })
    },
    REMOVE_COLLECTION (context, collection) {
      apollo.mutate({
        mutation: RemoveCollectionMutation,
        variables: {
          id: collection.id
        }
      }).then((result) => {
        context.commit('REMOVE_COLLECTION', collection)
        context.dispatch('ADD_ALERT', { type: 'inverse', message: 'La colletion a été supprimée', show: true })
      })
    },
    ADD_BOOKMARK (context, { title, url, collectionId }) {
      apollo.mutate({
        // Perfom mutation
        mutation: NewBookmarkMutation,
        variables: { title, url, collectionId },
        // Optimistic response
        optimisticResponse: {
          id: -1,
          title: title,
          url: url
        }
        // },
        // // Update cache of query which depends on the mutation data
        // // @see http://dev.apollodata.com/core/read-and-write.html#updating-the-cache-after-a-mutation
        // // @see http://dev.apollodata.com/react/api-mutations.html#graphql-mutation-options-update
        // // @see https://dev-blog.apollodata.com/mutations-and-optimistic-ui-in-apollo-client-517eacee8fb0
        // update: (proxy, { data: { createBookmark } }) => {
        //   // Update CollectionsQuery
        //
        //   const variables = { offset: 0, limit: 100 }
        //   const data = proxy.readQuery({ query: CollectionsQuery, variables })
        //
        //   data.collections.edges.map((collection) => {
        //     if (collection.id === payload.collectionId) {
        //       collection.bookmarks.total++
        //     }
        //   })
        //
        //   proxy.writeQuery({ query: CollectionsQuery, variables, data })
        //
        //   // Update CollectionQuery
        //
        //   const variables2 = { id: payload.collectionId, offset: 0, limit: 100 }
        //   const data2 = proxy.readQuery({ query: CollectionQuery, variables })
        //
        //   data2.bookmarks.total++
        //
        //   proxy.writeQuery({ query: CollectionQuery, variables2, data2 })
        // }
      }).then((result) => {
        let bookmark = {
          id: result.data.createBookmark.id,
          title: result.data.createBookmark.title,
          url: result.data.createBookmark.url,
          collectionId
        }

        // Update state
        context.commit('ADD_BOOKMARK', { bookmark, collectionId })
        context.commit('CLOSE_ADD_BOOKMARK_MODAL')
        context.dispatch('ADD_ALERT', { type: 'inverse', message: 'Votre favoris a été ajouté', show: true })
      })
    },
    REMOVE_BOOKMARK (context, { bookmark, collectionId }) {
      apollo.mutate({
        mutation: RemoveBookmarkMutation,
        variables: {
          id: bookmark.id
        }
      }).then((result) => {
        if (result.data.removeBookmark === true) {
          context.commit('REMOVE_BOOKMARK', { collectionId: collectionId, bookmark: bookmark })
          context.dispatch('ADD_ALERT', { type: 'inverse', message: 'Le favoris a été supprimé', show: true })
        }
      })
    },
    MOVE_BOOKMARK (context, { bookmark, collection }) {
      apollo.mutate({
        mutation: UpdateBookmarkMutation,
        variables: {
          id: bookmark.id,
          title: bookmark.title,
          url: bookmark.url,
          collectionId: collection.id
        }
      }).then((result) => {
        let newBookmark = {
          id: bookmark.id,
          title: bookmark.title,
          url: bookmark.url,
          collectionId: collection.id
        }

        context.commit('REMOVE_BOOKMARK', { bookmark, collectionId: bookmark.collectionId })
        context.commit('ADD_BOOKMARK', { bookmark: newBookmark, collectionId: newBookmark.collectionId })
        context.dispatch('ADD_ALERT', { type: 'inverse', message: 'Le favoris a été déplacé', show: true })
      })
    },
    ADD_ALERT (context, alert) {
      context.commit('ADD_ALERT', alert)
      setTimeout(() => { context.commit('REMOVE_ALERT', alert) }, 5000)
    }
  }
})

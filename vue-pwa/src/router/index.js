import Vue from 'vue'
import Router from 'vue-router'

import BookmarkList from '@/components/BookmarkList'
import Collection from '@/components/Collection'
import EditCollection from '@/components/EditCollection'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: BookmarkList
    },
    {
      path: '/collection/:id',
      name: 'Collection',
      component: Collection
    },
    {
      path: '/collection/:id/edit',
      name: 'EditCollection',
      component: EditCollection
    }
  ]
})

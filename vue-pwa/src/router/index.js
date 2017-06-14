import Vue from 'vue'
import Router from 'vue-router'

import BookmarkList from '@/components/BookmarkList'

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
      component: BookmarkList
    }
  ]
})

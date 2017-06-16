<template>
    <div id="app">

        <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
            <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <router-link class="navbar-brand" :to="{ name: 'Home' }">
              <img src="./assets/elephant.svg" width="30" height="30" alt="">
              Elephant
            </router-link>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-sm-4 col-md-3 hidden-xs-down bg-faded sidebar">

                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item text-sm-center pl-2 pr-2">
                            <button type="button" class="btn btn-success btn-block" v-on:click="$store.commit('openAddBookmarkModal')">
                                <i class="fa fa-star-o"></i>
                                Ajouter un favoris
                            </button>
                        </li>
                    </ul>
                    <collection-nav></collection-nav>
                    <ul class="nav nav-pills flex-column new-collection-menu col-sm-4 col-md-3 pl-0 pr-0">
                        <li class="nav-item">
                            <button type="button" class="btn btn-default btn-block" v-on:click="$store.commit('openAddCollectionModal')">
                                <i class="fa fa-folder-o"></i>
                                Nouvelle collection ...
                            </button>
                        </li>
                    </ul>

                </nav>
                <main class="col-sm-8 offset-sm-4 col-md-9 offset-md-3 pt-3">
                    <router-view></router-view>
                </main>
            </div>
        </div>

        <new-bookmark-modal></new-bookmark-modal>
        <new-collection-modal :open="newCollectionOpen" v-on:close="newCollectionOpen = false"></new-collection-modal>

    </div>
</template>

<script>
import CollectionNav from '@/components/CollectionNav'
import NewBookmarkModal from '@/components/NewBookmarkModal'
import NewCollectionModal from '@/components/NewCollectionModal'

export default {
  name: 'app',
  data: () => ({
    newBookmarkOpen: false,
    newCollectionOpen: false
  }),
  components: {
    CollectionNav,
    NewBookmarkModal,
    NewCollectionModal
  }
}
</script>

<style lang="sass">
  @import "sass/app"
</style>

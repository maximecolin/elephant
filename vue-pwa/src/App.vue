<script>
  import CollectionNav from '@/components/CollectionNav'
  import NewBookmarkModal from '@/components/NewBookmarkModal'
  import NewCollectionModal from '@/components/NewCollectionModal'
  import Alerts from '@/components/Alerts'

  export default {
    name: 'app',
    components: {
      CollectionNav,
      NewBookmarkModal,
      NewCollectionModal,
      Alerts
    },
    computed: {
      ready () {
        return this.$store.state.ready
      }
    },
    mounted () {
      this.$store.dispatch('INIT')
    },
    methods: {
      close () {
        if (this.$store.state.modal.addBookmark) {
          this.$store.commit('CLOSE_ADD_BOOKMARK_MODAL')
        }

        if (this.$store.state.modal.addCollection) {
          this.$store.commit('CLOSE_ADD_COLLECTION_MODAL')
        }
      }
    }
  }
</script>

<template>
    <div id="app" v-on:keyup.esc="close()">

        <template v-if="ready">

            <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
                <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <router-link class="navbar-brand" :to="{ name: 'Home' }">
                  <img src="./assets/elephant.svg" width="40" height="30" alt="">
                  Elephant
                </router-link>
            </nav>

            <div class="container-fluid">
                <div class="row">
                    <nav class="col-sm-4 col-md-3 hidden-xs-down bg-faded sidebar">

                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item text-sm-center pl-2 pr-2">
                                <button type="button" class="btn btn-success btn-block" v-on:click="$store.commit('OPEN_ADD_BOOKMARK_MODAL')">
                                    <i class="fa fa-star-o"></i>
                                    Ajouter un favoris
                                </button>
                            </li>
                        </ul>
                        <collection-nav></collection-nav>
                        <ul class="nav nav-pills flex-column new-collection-menu col-sm-4 col-md-3 pl-0 pr-0">
                            <li class="nav-item">
                                <button type="button" class="btn btn-default btn-block" v-on:click="$store.commit('OPEN_ADD_COLLECTION_MODAL')">
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

            <alerts></alerts>
            <new-bookmark-modal></new-bookmark-modal>
            <new-collection-modal></new-collection-modal>

        </template>
        <template v-else>
            <div class="loader"></div>
        </template>

    </div>
</template>

<style lang="sass">
  @import "sass/app"
</style>

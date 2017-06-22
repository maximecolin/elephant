<script>
  import draggable from 'vuedraggable'

  export default {
    components: {
      draggable
    },
    props: {
      collection: Object
    },
    computed: {
      bookmarks: {
        get () {
          return []
        },
        set (bookmarks) {
          console.log(bookmarks)
          this.$store.dispatch('MOVE_BOOKMARK', { bookmark: bookmarks[0], collection: this.collection })
        }
      }
    }
  }
</script>

<template>
    <draggable v-model="bookmarks" :element="'li'" :options="{ group: 'bookmarks' }" class="nav-item">
        <router-link class="nav-link toggle-item-hover" v-bind:class="{ active: collection.id === $route.params.id }" :to="{ name: 'Collection', params: { id: collection.id } }">
            {{ collection.title }}
            <span class="badge badge-pill badge-default pull-right toggle-item-hover-show">{{ collection.bookmarks }}</span>
            <router-link :to="{ name: 'EditCollection', params: { id: collection.id } }" class="btn btn-link btn-sm pull-right toggle-item-hover-hide">Edit.</router-link>
            <button type="button" class="btn btn-link btn-sm pull-right toggle-item-hover-hide mr-2" v-on:click.prevent.stop="remove(collection)">Suppr.</button>
        </router-link>
    </draggable>
</template>

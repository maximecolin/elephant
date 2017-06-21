<script>
  export default {
    computed: {
      collections () {
        return this.$store.state.collections
      }
    },
    methods: {
      remove (collection) {
        if (confirm('Confirmer la suppression ?')) {
          this.$store.dispatch('REMOVE_COLLECTION', collection)
          if (this.$route.params.id === collection.id) {
            this.$router.push({ name: 'Home' })
          }
        }
      }
    }
  }
</script>

<template>
    <ul class="nav nav-pills flex-column collections-nav">
        <li class="nav-item" v-for="collection in collections" v-if="collection !== undefined">
            <router-link class="nav-link toggle-item-hover" v-bind:class="{ active: collection.id === $route.params.id }" :to="{ name: 'Collection', params: { id: collection.id } }">
                {{ collection.title }}
                <span class="badge badge-pill badge-default pull-right toggle-item-hover-show">{{ collection.bookmarks }}</span>
                <router-link :to="{ name: 'EditCollection', params: { id: collection.id } }" class="btn btn-link btn-sm pull-right toggle-item-hover-hide">Edit.</router-link>
                <button type="button" class="btn btn-link btn-sm pull-right toggle-item-hover-hide mr-2" v-on:click.prevent.stop="remove(collection)">Suppr.</button>
            </router-link>
        </li>
    </ul>
</template>

<script>
  export default {
    computed: {
      collections () {
        return this.$store.state.collections
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
            </router-link>
        </li>
    </ul>
</template>

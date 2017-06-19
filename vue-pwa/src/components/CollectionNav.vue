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
    <ul class="nav nav-pills flex-column">
        <li class="nav-item" v-for="collection in collections" v-if="collection !== undefined">
            <router-link class="nav-link" v-bind:class="{ active: collection.id === $route.params.id }" :to="{ name: 'Collection', params: { id: collection.id } }">
                {{ collection.title }}
                <span class="badge badge-pill badge-default pull-right">{{ collection.bookmarks }}</span>
            </router-link>
        </li>
    </ul>
</template>

<script>
import CollectionsQuery from '../graphql/CollectionsQuery'

export default {
  data: () => ({
    collections: [],
    loading: 0
  }),
  apollo: {
    collections: {
      query: CollectionsQuery,
      loadingKey: 'loading'
    }
  }
}
</script>

<template>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item" v-for="collection in collections.edges">
            <router-link class="nav-link" v-bind:class="{ active: collection.id === $route.params.id }" :to="{ name: 'Collection', params: { id: collection.id } }">
                {{ collection.title }}
                <span class="badge badge-pill badge-default pull-right">{{ collection.bookmarks.total }}</span>
            </router-link>
        </li>
    </ul>
</template>

<style>
</style>

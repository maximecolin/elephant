<script>
import gql from 'graphql-tag'

const collectionsQuery = gql`
  query {
    collections(offset: 0 limit: 100) {
      edges {
        id
        title
        bookmarks {
          total
        }
      }
    }
  }
`

export default {
  data: () => ({
    collections: [],
    loading: 0
  }),
  apollo: {
    collections: {
      query: collectionsQuery,
      loadingKey: 'loading'
    }
  }
}
</script>

<template>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item" v-for="collection in collections.edges">
            <router-link class="nav-link" :to="{ name: 'Collection', params: { id: collection.id } }">
                {{ collection.title }}
                <span class="badge badge-pill badge-default pull-right">{{ collection.bookmarks.total }}</span>
            </router-link>
        </li>
    </ul>
</template>

<style>
</style>

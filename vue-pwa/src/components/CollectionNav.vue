<script>
import gql from 'graphql-tag'

const collectionsQuery = gql`
  query {
    collections(offset: 0 limit: 100) {
      edges {
        id
        title
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
            <a class="nav-link" href="#">{{ collection.title }}</a>
        </li>
    </ul>
</template>

<style>
</style>

<script>
  import gql from 'graphql-tag'

  const bookmarksQuery = gql`
    query {
      bookmarks {
        total
        offset
        limit
        edges {
          id
          title
          url
        }
      }
    }
  `

  export default{
    data: () => ({
      bookmarks: [],
      loading: 0
    }),
    apollo: {
      bookmarks: {
        watchQuery: bookmarksQuery,
        loadingKey: 'loading'
      }
    }
  }
</script>

<template>
    <div>
        <ul>
            <li v-for="bookmark in bookmarks.edges">
                {{ bookmark.url }}
            </li>
        </ul>
    </div>
</template>

<style>
</style>

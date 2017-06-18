<script>
  import BookmarksQuery from '../graphql/BookmarksQuery'

  export default{
    data: () => ({
      bookmarks: [],
      loading: 0
    }),
    apollo: {
      bookmarks: {
        query: BookmarksQuery,
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

<script>
  import CollectionQuery from '../graphql/CollectionQuery'

  export default {
    data: () => ({
      collection: null,
      loading: 0,
      page: 1,
      limit: 10,
      id: null
    }),
    mounted () {
      this.handleRoute()
    },
    computed: {
      offset () {
        return (this.page - 1) * this.limit
      }
    },
    methods: {
      handleRoute () {
        this.id = parseInt(this.$route.params.id, 10)
        this.page = this.$route.query.page ? parseInt(this.$route.query.page, 10) : 1
      }
    },
    apollo: {
      collection: {
        query: CollectionQuery,
        variables () {
          return {
            id: this.id,
            offset: this.offset,
            limit: this.limit
          }
        },
        loadingKey: 'loading'
      }
    },
    watch: {
      $route () {
        this.handleRoute()
      }
    }
  }
</script>

<template>
    <div>
        <template v-if="collection === null || loading > 0">
            Loading ...
        </template>
        <template v-else>
            <h1>{{ collection.title }}</h1>
            <ul>
                <li v-for="bookmark in collection.bookmarks.edges">
                    {{ bookmark.url }}
                </li>
            </ul>
        </template>
    </div>
</template>

<style>
</style>

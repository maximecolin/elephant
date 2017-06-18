<script>
  export default {
    data: () => ({
      page: 1,
      limit: 10
    }),
    mounted () {
      this.handleRoute()
    },
    computed: {
      offset () {
        return (this.page - 1) * this.limit
      },
      collection () {
        return this.$store.state.collections.edges[this.id] || null
      },
      bookmarks () {
        return this.collection.bookmarks.edges || []
      },
      id () {
        return parseInt(this.$route.params.id, 10)
      }
    },
    methods: {
      handleRoute () {
        this.page = this.$route.query.page ? parseInt(this.$route.query.page, 10) : 1
        this.$store.dispatch('GET_COLLECTION', this.id)
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
        <template v-if="collection === null">
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

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
        return this.$store.state.collections[this.id] || null
      },
      bookmarks () {
        return this.$store.state.bookmarks[this.id] || []
      },
      id () {
        return parseInt(this.$route.params.id, 10)
      }
    },
    methods: {
      handleRoute () {
        this.page = this.$route.query.page ? parseInt(this.$route.query.page, 10) : 1

        // Don't call GET_COLLECTION if bookmarks are already fetched to prevent collection to be reset from apollo cache
        if (this.$store.state.bookmarks[this.id] === undefined) {
          this.$store.dispatch('GET_COLLECTION', this.id)
        }
      },
      remove (bookmark) {
        this.$store.dispatch('REMOVE_BOOKMARK', { collectionId: this.id, bookmark: bookmark })
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
            <ul class="list-group">
                <li v-for="bookmark in bookmarks" class="list-group-item collection-bookmark">
                    {{ bookmark.title }}<br>
                    {{ bookmark.url }}<br>

                    <button type="button" class="btn btn-danger btn-sm" v-on:click="remove(bookmark)">&times;</button>
                </li>
            </ul>
        </template>
    </div>
</template>

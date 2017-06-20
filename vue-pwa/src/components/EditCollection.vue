<script>
  export default {
    data () {
      return {
        id: null,
        title: null
      }
    },
    computed: {
      collection () {
        return this.$store.state.collections[this.id] || null
      }
    },
    methods: {
      handleRoute () {
        this.id = this.$route.params.id
        this.title = this.collection ? this.collection.title : null
      },
      submit () {
        this.$store.dispatch('UPDATE_COLLECTION', { id: this.id, title: this.title })
      }
    },
    mounted () {
      this.handleRoute()
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
        <h1>Edit collection</h1>
        <form v-on:submit.prevent="submit()">
            <div class="form-group">
                <label for="editBookmarkTitle">Titre</label>
                <input type="text" class="form-control" id="editBookmarkTitle" v-model="title" placeholder="Entrez un titre">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
        </form>
    </div>
</template>

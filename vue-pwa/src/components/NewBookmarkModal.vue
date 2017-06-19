<script>
  import Modal from '@/components/Modal'

  export default {
    components: {
      Modal
    },
    data () {
      return {
        title: null,
        url: null
      }
    },
    computed: {
      isOpen () {
        return this.$store.state.modal.addBookmark
      }
    },
    methods: {
      submit () {
        let bookmark = {
          title: this.title,
          url: this.url,
          collectionId: this.$route.params.id
        }

        this.$store.dispatch('ADD_BOOKMARK', bookmark)
      },
      close () {
        this.$store.commit('CLOSE_ADD_BOOKMARK_MODAL')
        this.title = null
        this.url = null
      }
    }
  }
</script>

<template>

    <modal :open="isOpen" v-on:close="close()">
        <header slot="header">
            <i class="fa fa-star-o"></i> Nouveau favoris
        </header>
        <main>
            <div>
                <form v-on:submit.prevent="submit()">
                    <div class="form-group">
                        <label for="newBookmarkTitle">Titre</label>
                        <input type="text" class="form-control" id="newBookmarkTitle" v-model="title" placeholder="Entrez un titre">
                    </div>
                    <div class="form-group">
                        <label for="newBookmarkUrl">Url</label>
                        <input type="url" class="form-control" id="newBookmarkUrl" v-model="url" placeholder="Entrez l'url">
                    </div>
                </form>
            </div>
        </main>
        <footer slot="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="close()">Annuler</button>
            <button type="button" class="btn btn-primary" v-on:click="submit()">Save changes</button>
        </footer>
    </modal>

</template>

<script>
  import Modal from '@/components/Modal'

  export default {
    components: {
      Modal
    },
    data () {
      return {
        title: null
      }
    },
    computed: {
      isOpen () {
        return this.$store.state.modal.addCollection
      }
    },
    methods: {
      submit () {
        let collection = {
          title: this.title
        }

        this.$store.dispatch('ADD_COLLECTION', collection)
      },
      close () {
        this.$store.commit('CLOSE_ADD_COLLECTION_MODAL')
        this.title = null
      }
    }
  }
</script>

<template>

    <modal :open="isOpen" v-on:close="close()">
        <header slot="header">
            <i class="fa fa-folder-o"></i> Nouvelle collection
        </header>
        <main>
            <div>
                <form v-on:submit.prevent="submit()">
                    <div class="form-group">
                        <label for="newBookmarkTitle">Titre</label>
                        <input type="text" class="form-control" id="newBookmarkTitle" v-model="title" placeholder="Entrez un titre">
                    </div>
                </form>
            </div>
        </main>
        <footer slot="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="close()">Annuler</button>
            <button type="button" class="btn btn-primary" v-on:click="submit()">Enregistrer</button>
        </footer>
    </modal>

</template>

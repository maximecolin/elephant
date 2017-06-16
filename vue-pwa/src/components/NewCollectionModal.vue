<script>
  import Modal from '@/components/Modal'
  import NewCollectionMutation from '../graphql/NewCollectionMutation'

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
    watch: {
      open (value) {
        this.isOpen = value
      }
    },
    methods: {
      submit () {
        this.$apollo.mutate({
          mutation: NewCollectionMutation,
          variables: {
            title: this.title
          }
        })
      }
    }
  }
</script>

<template>

    <modal :open="isOpen" v-on:close="$store.commit('closeAddCollectionModal')">
        <header slot="header">
            <i class="fa fa-folder-o"></i> Nouvelle collection
        </header>
        <main>
            <div>
                <form>
                    <div class="form-group">
                        <label for="newBookmarkTitle">Titre</label>
                        <input type="text" class="form-control" id="newBookmarkTitle" v-model="title" placeholder="Entrez un titre">
                    </div>
                </form>
            </div>
        </main>
        <footer slot="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="$store.commit('closeAddCollectionModal')">Annuler</button>
            <button type="button" class="btn btn-primary" v-on:click="submit()">Enregistrer</button>
        </footer>
    </modal>

</template>

<style>
</style>

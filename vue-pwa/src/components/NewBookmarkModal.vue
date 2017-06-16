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
    watch: {
      open (value) {
        this.isOpen = value
      }
    }
  }
</script>

<template>

    <modal :open="isOpen" v-on:close="$store.commit('closeAddBookmarkModal')">
        <header slot="header">
            <i class="fa fa-star-o"></i> Nouveau favoris
        </header>
        <main>
            <div>
                <form>
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="$store.commit('closeAddBookmarkModal')">Annuler</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </footer>
    </modal>

</template>

<style>
</style>

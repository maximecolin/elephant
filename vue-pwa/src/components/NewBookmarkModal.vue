<script>
  import Modal from '@/components/Modal'

  export default {
    components: {
      Modal
    },
    props: {
      open: Boolean
    },
    data () {
      return {
        isOpen: this.open,
        title: null,
        url: null
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

    <modal :open="isOpen" v-on:close="$emit('close')">
        <header slot="header">
            Nouveau favoris
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="isOpen = false">Annuler</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </footer>
    </modal>

</template>

<style>
</style>

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
            <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="isOpen = false">Annuler</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </footer>
    </modal>

</template>

<style>
</style>

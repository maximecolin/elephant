
<script>
  export default{
    data () {
      return {
        display: this.open,
        show: this.open
      }
    },
    props: {
      open: Boolean
    },
    methods: {
      close () {
        this.show = false
        setTimeout(() => {
          this.display = false
          this.$emit('close')
        }, 400)
      }
    },
    watch: {
      open (value) {
        if (value === true) {
          this.display = true
          setTimeout(() => { this.show = true }, 100)
        } else {
          this.show = false
          setTimeout(() => { this.display = false }, 400)
        }
      }
    }
  }
</script>

<template>
    <div id="addModal" class="modal fade" v-bind:class="{ show: show }" v-bind:style="{ display: display ? 'block' : 'none' }" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" v-on:click="close()">
        <div class="modal-dialog" role="document" v-on:click.stop="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="close()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Woohoo, you're reading this text in a modal!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="close()">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
</style>

<script>
  import CollectionNavItem from '@/components/CollectionNavItem'

  export default {
    components: {
      CollectionNavItem
    },
    computed: {
      collections () {
        return this.$store.state.collections
      }
    },
    methods: {
      remove (collection) {
        if (confirm('Confirmer la suppression ?')) {
          this.$store.dispatch('REMOVE_COLLECTION', collection)
          if (this.$route.params.id === collection.id) {
            this.$router.push({ name: 'Home' })
          }
        }
      }
    }
  }
</script>

<template>
    <ul class="nav nav-pills flex-column collections-nav">
        <collection-nav-item v-for="collection in collections" v-if="collection !== undefined" :collection="collection" :key="collection.id"></collection-nav-item>
    </ul>
</template>

<script>
  export default{
    computed: {
      alerts () {
        return this.$store.state.alerts
      }
    },
    methods: {
      remove (alert) {
        this.$store.commit('REMOVE_ALERT', alert)
      }
    }
  }
</script>

<template>
    <div class="alerts">
        <div class="alert alert-dismissible fade" v-bind:class="['alert-' + alert.type, alert.show ? 'show' : '']" role="alert" v-for="alert in alerts" v-on:click="remove(alert)">
            {{ alert.message }}
        </div>
    </div>
</template>

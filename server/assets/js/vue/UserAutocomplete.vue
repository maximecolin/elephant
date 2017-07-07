
<script>
  import axios from 'axios'
  import _ from 'lodash'

  export default {
    data () {
      return {
        users: [],
        loading: false,
        term: null,
        id: null,
        user: { id: null, name: null },
        isOpen: true
      }
    },
    props: {
      endpoint: String,
      name: String
    },
    computed: {
      hasUsers () {
        return this.users.length > 0;
      }
    },
    mounted () {
      // Close
      document.addEventListener('click', this.close.bind(this))
    },
    methods: {
      select (user) {
        this.user.id = user.id
        this.user.name = user.name
        this.term = user.name
        this.isOpen = false
      },
      open () {
        this.isOpen = true
      },
      close () {
        this.isOpen = false
      },
      search: _.debounce (function () {
        this.loading = true

        axios
          .get(this.endpoint, { params: { term: this.term.trim() } })
          .then((response) => {
            this.users = response.data
            this.isOpen = true
            this.loading = false
          })
          .catch((error) => {
            console.log(error)
            this.isOpen = false
            this.loading = false
          })

      }, 500)
    },
    watch: {
      term () {
        if (this.term === null || this.term === '') {
          this.users = []

          return
        }

        if (this.term === this.user.name) {
          return
        } else {
          this.user.id = null
          this.user.name = null
        }

        this.search()
      }
    }
  }
</script>

<template>
    <div class="dropdown show w-100" v-on:click.stop>
        <input type="hidden" v-bind:name="name" v-model="user.id" />
        <input type="text" class="form-control w-100" v-model="term" v-on:focus="open()" />
        <ul class="dropdown-menu w-100" v-show="!hasUsers && loading">
            <li class="dropdown-item">
                Chargement...
            </li>
        </ul>
        <ul class="dropdown-menu w-100" v-show="hasUsers && isOpen">
            <li class="dropdown-item" v-for="user in users" v-on:click="select(user)">
                <strong>{{ user.name }}</strong><br >
                {{ user.email }}
            </li>
        </ul>
    </div>
</template>

// import $ from 'jquery'

import 'bootstrap'
import Vue from 'vue'
import DataDelete from './component/DataDelete'
import UserAutocomplete from './vue/UserAutocomplete.vue'

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

const elements = document.querySelectorAll('[data-delete]')
for (let element of elements) { new DataDelete(element) }

new Vue({
  el: '#app',
  components: {
    UserAutocomplete
  }
})

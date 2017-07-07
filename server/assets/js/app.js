// import $ from 'jquery'

import 'bootstrap'
import Vue from 'vue'
import UserAutocomplete from './vue/UserAutocomplete.vue'

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

new Vue({
  el: '#app',
  components: {
    UserAutocomplete
  },
  methods: {
    deleteForm (url) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = url;
      const method = document.createElement('input');
      method.type = 'hidden';
      method.name = '_method';
      method.value = 'DELETE';
      form.append(method);
      document.body.appendChild(form);
      form.submit();
    }
  }
})

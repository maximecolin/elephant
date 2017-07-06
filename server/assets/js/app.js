// import $ from 'jquery'

import 'bootstrap'
import DataDelete from './component/DataDelete'

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

const elements = document.querySelectorAll('[data-delete]')
for (let element of elements) { new DataDelete(element) }

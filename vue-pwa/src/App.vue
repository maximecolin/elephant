<template>
  <div id="app">

    <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">Elephant</a>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-4 col-md-3 hidden-xs-down bg-faded sidebar">

          <ul class="nav nav-pills flex-column">
            <li class="nav-item text-sm-center pl-2 pr-2">
              <button type="button" class="btn btn-success btn-block">
                <i class="fa fa-star-o"></i>
                Ajouter un favoris
              </button>
            </li>
          </ul>
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Overview <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Reports</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Analytics</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Export</a>
            </li>
          </ul>
          <ul class="nav nav-pills flex-column new-collection-menu col-sm-4 col-md-3 pl-0 pr-0">
            <li class="nav-item">
              <button type="button" class="btn btn-default btn-block">
                <i class="fa fa-folder-o"></i>
                Nouvelle collection ...
              </button>
            </li>
          </ul>

        </nav>
        <main class="col-sm-8 offset-sm-4 col-md-9 offset-md-3 pt-3">
          <bookmark-list></bookmark-list>
        </main>
      </div>
      <!--<router-view></router-view>-->

    </div>
  </div>
</template>

<script>
import BookmarkList from '@/components/BookmarkList'

export default {
  name: 'app',
  components: {
    BookmarkList
  }
}
</script>

<style lang="sass">
  @import "sass/app"
</style>

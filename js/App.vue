<script setup>
import { RouterLink, RouterView } from "vue-router";
import HelloWorld from "./components/HelloWorld.vue";
</script>

<template>
  <div class="demo-container">
    <!-- Drawer -->
    <ui-drawer type="modal" nav-id="demo-menu" viewport-height>
      <ui-drawer-header>
        <ui-drawer-title>Title</ui-drawer-title>
        <ui-drawer-subtitle>Subtitle</ui-drawer-subtitle>
      </ui-drawer-header>
      <ui-drawer-content>
        <ui-nav>
          <ui-nav-item active><RouterLink to="/" active>Home</RouterLink></ui-nav-item>
          <ui-nav-item><RouterLink to="/about">About</RouterLink></ui-nav-item>
        </ui-nav>
      </ui-drawer-content>
    </ui-drawer>
    <!-- Content -->
    <div class="demo-content">
      <!-- App bar -->
      <!-- App bar -->
      <ui-top-app-bar
        fixed
        class="demo-app-bar"
        content-selector=".demo-app-content"
        nav-id="demo-menu"
      >
        Title
      </ui-top-app-bar>
      <!-- App content -->
      <div class="demo-app-content">
        <RouterView />
      </div>
    </div>
  </div>
</template>

<style>
.demo-container {
  z-index: 99999;
}
.demo-content {
  width: 100%;
}

.demo-app-content {
  height: 100%;
  overflow: auto;
}
</style>

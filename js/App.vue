<script setup>
import PrimaryNav from "./components/ui/PrimaryNav.vue";
import PrimaryHeader from "./components/ui/PrimaryHeader.vue";
import { db } from "./db/locations.js";
// console.log(getAll());
console.log(db);

</script>

<template>
  <div id="stock-man-app">
    <PrimaryNav />
    <div class="stock-man-app-wrapper">
      <PrimaryHeader />
      <div class="stock-man-app-content">
        <RouterView />
      </div>
    </div>
  </div>
</template>

<!-- <style>
#stock-man-app {
  z-index: 99999;
}
.demo-content {
  width: 100%;
}

.stock-man-app-wrapper {
  height: 100%;
  overflow: auto;
}
#app{
    position: absolute;
    top: -10px;
    left: -54px;
    height: calc(100vh - 36px);
    position: absolute;
    top: -10px;
    left: -54px;
    height: calc(100vh - 36px);
    width: calc(100vw - 144px);
    background: antiquewhite;
    overflow: visible;
    display: flex;
    grid-template-columns: none;
}
</style> -->

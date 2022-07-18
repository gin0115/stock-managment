<script setup>
import PrimaryNav from "./components/ui/PrimaryNav.vue";
import PrimaryHeader from "./components/ui/PrimaryHeader.vue";
import { db } from "./db/locations.js";
// console.log(getAll());
console.log(db);

const id = await db.friends.add({
          name: 'this.friendName',
          age: 12,
        });

        let r = `Friend ${this.friendName}
          successfully added. Got id ${id}`;

          console.log(r, db.friends.get(id));
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

<style>
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
}
</style>

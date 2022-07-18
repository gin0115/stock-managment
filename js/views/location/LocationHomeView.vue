<script setup>
import { useLocationStore } from '@/store/location'
 import { storeToRefs } from 'pinia'

const {getCurrentSite} = storeToRefs(useLocationStore())
console.log(getCurrentSite, useLocationStore);
</script>

<template>
<ui-tabs v-model="active">
  <ui-tab>Tab One</ui-tab>
  <ui-tab>Tab Two</ui-tab>
  <ui-tab>Tab Three</ui-tab>
</ui-tabs>
{{ getCurrentSite }}
<ui-panels v-model="active">
  <ui-panel>Panel One{{ currentSite }}</ui-panel>
  <ui-panel>Panel Two</ui-panel>
  <ui-panel>Panel Three</ui-panel>
</ui-panels>
</template>

<!-- <script setup>
const tabs = [
  {
    icon: 'phone',
    url: '#recents'
  },
  {
    icon: 'favorite',
    url: '#favorites'
  },
  {
    icon: 'person_pin',
    url: '#nearby'
  }
];

const data = {
    active: 0,
};

</script> -->
<script setup>
import {useWpStore} from "../../store/wp.js"
const {user, i18n} = useWpStore();
</script>

<template>
  <div class="greetings">
   Hello {{ user.name }}
  </div>
</template>
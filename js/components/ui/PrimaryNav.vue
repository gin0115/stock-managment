<script setup>
import {useWpStore} from "../../store/wp.js"

const {i18n} = useWpStore();
</script>

<template>
    <ui-drawer type="modal" nav-id="demo-menu" viewport-height>
        <ui-drawer-header>
            <ui-drawer-title>{{ i18n.main.title }}</ui-drawer-title>
            <ui-drawer-subtitle>{{ i18n.main.subtitle }}</ui-drawer-subtitle>
        </ui-drawer-header>
        <ui-drawer-content>
            <ui-nav>
                <ui-nav-item active>
                    <RouterLink to="/" active>{{ i18n.nav.home }}</RouterLink>
                </ui-nav-item>
                <ui-nav-item>
                    <RouterLink to="/about">{{ i18n.nav.locations }}</RouterLink>
                </ui-nav-item>
            </ui-nav>
        </ui-drawer-content>
    </ui-drawer>
</template>



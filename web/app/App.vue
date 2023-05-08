<template>
    <n-notification-provider>
        <n-card title="Fruits" size="huge">
            <FruitsTable/>
        </n-card>
    </n-notification-provider>
</template>

<script setup lang="ts">
import FruitsTable from "./Components/FruitsTable.vue";
import {NCard, NNotificationProvider} from 'naive-ui'
</script>
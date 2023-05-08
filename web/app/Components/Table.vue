<template>
    <n-input
            v-model:value="filterName as string"
            placeholder="Search by name"
            clearable
            size="small"
            style="width: 200px; margin-bottom: 10px"
            @change="updateTable(page, pageSize)"
    />
    <n-input
            v-model:value="filterFamily as string"
            placeholder="Search by family"
            clearable
            size="small"
            style="width: 200px; margin-bottom: 10px"
            @change="updateTable(page, pageSize)"
    />

    <n-data-table
            pagination-behavior-on-filter="first"
            :columns="columns"
            :data="fruitRef.fruits?.data"
            :loading="fruitRef.loading"
            :pagination="paginationReactive"
    />
</template>

<script lang="ts" setup>
import {onMounted, reactive, ref} from 'vue'
import {DataTableColumns, NDataTable, NInput} from 'naive-ui'
import {getFruits, fruitRef, ParamsT} from "../Api/useFruites";

const filterName = ref<string | null>(null);
const filterFamily = ref<string | null>(null);
const page = ref<number>(1);
const pageSize = ref<number>(15);

type RowData = {
    id: number
    name: string
    family: string
    order: string
    genus: string
}

const columns: DataTableColumns<RowData> = [
    {
        title: 'Name',
        key: 'name'
    },
    {
        title: 'Family',
        key: 'family'
    },
    {
        title: 'Order',
        key: 'order'
    },
    {
        title: 'Genus',
        key: 'genus'
    }
]

const paginationReactive = reactive({
    page: page.value,
    pageSize: pageSize.value,
    itemCount: fruitRef.fruits?.['pagination']?.total as number,
    showSizePicker: true,
    pageSizes: [15, 25, 50, 100],
    onChange: async (page: number) => {
        await updateTable(page, pageSize.value)
    },
    onUpdatePageSize: async (pageSize: number) => {
        await updateTable(page.value, pageSize)
    }
})
const params: ParamsT = reactive({
    page: page.value,
    pageSize: pageSize.value,
    filter: {
        name: filterName.value,
        family: filterFamily.value,
    }
});
onMounted(() => {
    getFruits(params);
});
const updateTable = async (page: number, pageSize: number) => {
    await getFruits({
        page: page,
        pageSize: pageSize,
        filter: {
            name: filterName.value,
            family: filterFamily.value,
        }
    });
}

</script>
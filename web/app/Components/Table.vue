<template>
    <n-input
            v-model:value="filterName as string"
            placeholder="Search by name"
            clearable
            size="small"
            style="width: 200px; margin-bottom: 10px"
            @change="updateTable(page)"
    />
    <n-input
            v-model:value="filterFamily as string"
            placeholder="Search by family"
            clearable
            size="small"
            style="width: 200px; margin-bottom: 10px"
            @change="updateTable(page)"
    />

    <n-data-table
            pagination-behavior-on-filter="first"
            :columns="columns"
            :remote="true"
            :data="fruitRef.fruits.data"
            :loading="fruitRef.loading"
            :pagination="paginationReactive"
    />
</template>

<script lang="ts" setup>
import {computed, h, onMounted, reactive, ref} from 'vue'
import {DataTableColumns, NButton, NDataTable, NInput} from 'naive-ui'
import {getFruits, fruitRef, ParamsT} from "../Api/useFruites";

const filterName = ref<string | null>(null);
const filterFamily = ref<string | null>(null);
const page = ref<number>(1);

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
    },
    {
      title: 'Action',
      key: 'actions',
      render (row) {
        return h(
          NButton,
          {
            strong: true,
            tertiary: true,
            size: 'small',
            onClick: () => ''
          },
          { default: () => '' }
        )
      }
    }
]

const paginationReactive = reactive({
    page: page.value,
    itemCount: 0,
    onChange: async (page: number) => {
        await updateTable(page)
    },
})
const params: ParamsT = reactive({
    page: page.value,
    filter: {
        name: filterName.value,
        family: filterFamily.value,
    }
});
onMounted(() => {
    getFruits(params).finally(() => {
        paginationReactive.itemCount = fruitRef.fruits.pagination.total;
    })
});
const updateTable = async (page: number) => {
    await getFruits({
        page: page,
        filter: {
            name: filterName.value,
            family: filterFamily.value,
        }
    });
    paginationReactive.itemCount = fruitRef.fruits.pagination.total;
    paginationReactive.page = page;
}

</script>
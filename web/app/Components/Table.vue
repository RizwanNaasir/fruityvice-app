<template>
    <n-data-table
            pagination-behavior-on-filter="first"
            :columns="columns"
            :data="fruitRef.fruits?.data"
            :loading="fruitRef.loading"
            :pagination="pagination"
    />
</template>

<script lang="ts" setup>
import {onMounted} from 'vue'
import {DataTableColumns, NDataTable} from 'naive-ui'
import {getFruits,fruitRef} from "../Api/useFruites";

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
    // {
    //     title: 'Address',
    //     key: 'address',
    //     defaultFilterOptionValues: [],
    //     filterOptions: [
    //         {
    //             label: 'London',
    //             value: 'London'
    //         },
    //         {
    //             label: 'New York',
    //             value: 'New York'
    //         }
    //     ],
    //     // filter (value, row) {
    //     //     return !!~row.address.indexOf(String(value))
    //     // }
    // }
]

const pagination = {
    pageSize: 2,
    showSizePicker: true,
    showQuickJumper: true,
};

onMounted(() => {
    getFruits();
});

</script>
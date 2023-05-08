<template>
   <div style="display: flex; justify-content: space-between; margin-bottom: 10px">
       <n-input
           v-model:value="filterName as string"
           placeholder="Search by name and press enter"
           clearable
           size="medium"
           style="width: 350px; margin-bottom: 10px"
           @change="updateTable(page)"
           :loading="fruitRef.loading"
       />
       <n-input
           v-model:value="filterFamily as string"
           placeholder="Search by family and press enter"
           clearable
           size="medium"
           style="width: 350px; margin-bottom: 10px"
           @change="updateTable(page)"
           :loading="fruitRef.loading"
       />
       <n-dropdown trigger="click" :options="favorites">
           <n-button>View Favorites!</n-button>
       </n-dropdown>
   </div>
    <n-data-table
            pagination-behavior-on-filter="first"
            :columns="columns"
            :remote="true"
            :data="fruitRef.fruits.data"
            :loading="fruitRef.loading"
            :pagination="paginationReactive"
    />
    <n-modal v-model:show="showModal">
        <n-card
                style="width: 600px"
                title="Nutrients"
                :bordered="false"
                size="huge"
                role="dialog"
                aria-modal="true"
        >
            <n-descriptions label-placement="top" title="">
                <n-descriptions-item label="Calories">
                    {{nutrients.calories}}
                </n-descriptions-item>
                <n-descriptions-item label="Fat">
                    {{ nutrients.fat }}
                </n-descriptions-item>
                <n-descriptions-item label="Sugar" :span="2">
                   {{ nutrients.sugar }}
                </n-descriptions-item>
                <n-descriptions-item label="Carbohydrates">
                    {{ nutrients.carbohydrates }}
                </n-descriptions-item>
                <n-descriptions-item label="Protein">
                    {{ nutrients.protein }}
                </n-descriptions-item>
            </n-descriptions>
        </n-card>
    </n-modal>

</template>

<script lang="ts" setup>
import {h, onMounted, reactive, ref} from 'vue'
import {
    DataTableColumns,
    NButton,
    NCard,
    NDataTable,
    NInput,
    NModal,
    NDescriptions,
    NDescriptionsItem,
    NDropdown, NText, NList, NListItem
} from 'naive-ui'
import {fruitRef, getFruits, getNutrients, ParamsT} from "../Api/useFruites";
import { useNotification } from 'naive-ui'

const notification = useNotification();
const filterName = ref<string | null>(null);
const filterFamily = ref<string | null>(null);
const page = ref<number>(1);
const showModal = ref(false);
const favorites = ref([])
const nutrients = ref<NutrientsT>({
    "id": 0,
    "calories": 0,
    "fat": "0.00",
    "sugar": "0.00",
    "carbohydrates": "0.00",
    "protein": "0.00"
});

type NutrientsT = {
    id: number,
    calories: number,
    fat: string,
    sugar: string,
    carbohydrates: string,
    protein: string
}

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
        render(row) {
            return [
                h(
                    NButton,
                    {
                        strong: true,
                        tertiary: true,
                        type: 'primary',
                        size: 'small',
                        onClick: () => updateFavorites(row),
                        style: {
                            marginRight: '5px'
                        }
                    },
                    {default: () => getFavoriteLabel(row)}
                ),
                h(
                    NButton,
                    {
                        strong: true,
                        tertiary: true,
                        size: 'small',
                        onClick: () => viewNutritionModal(row)
                    },
                    {default: () => 'View nutrition'}
                )
            ]
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
    }).catch((e) => {
        notification.error({
            title: 'Error',
            description: e.message
        });
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
const updateFavorites = (row) => {
    if (favorites.value.length === 10 && !favorites.value.find((item) => item.key === row.id)) {
        notification.error({
            title: 'Error',
            description: 'You can add only 10 items to favorites, please remove one of them and try again.'
        });
        return;
    }
    if (favorites.value.find((item) => item.key === row.id)) {
        favorites.value = favorites.value.filter((item) => item.key !== row.id);
    } else {
        favorites.value.push({
            key: row.id,
            type: 'render',
            render: () => renderCustomHeader(row)
        });
    }
}
const viewNutritionModal = async (row) => {
    await getNutrients(row.id).then((res) => {
        nutrients.value = res.data;
        showModal.value = true;
    }).catch((error) => {
        console.log(error);
        notification.error({
            title: 'Error',
            description: 'Something went wrong, please try again later.'
        });
    });
}
const getFavoriteLabel = (row) => {
    const favorite = favorites.value.find((item) => item.key === row.id);
    return favorite ? 'Remove from favorites' : 'Add to favorites';
}

function renderCustomHeader (row) {
    return h(NList, {
        style: {
            width: '100%',
            padding: '0.5rem',
            borderBottom: '1px solid #ebebeb'
        }
    }, {
        default: () => [
            h(NListItem, null, {
                default: () => [
                    h('div',{
                        style: {
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'space-between',
                            width: '100%'
                        }
                    }, {
                        default: () => [
                            h(NText, null, {
                                default: () => row.name
                            }),
                            h(NButton, {
                                size: 'small',
                                style: {
                                    marginLeft: '5px'
                                },
                                onClick: () => {
                                    favorites.value = favorites.value.filter((item) => item.key !== row.id);
                                }
                            }, {
                                default: () => 'Remove'
                            })
                        ]
                    }),
                ]
            })
        ]
    });
}
</script>
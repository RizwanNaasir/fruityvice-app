import {client} from "./client";
import {reactive} from "vue";

export type FruitRefT = {
    fruits: {
        data: [],
        pagination: {
            total: number,
            page: number,
            per_page: number,
            page_count: number
        }
    },
    loading: boolean,
    error: any,
}
export const fruitRef: FruitRefT = reactive({
    fruits: {
        data: [],
        pagination: {
            total: 0,
            page: 0,
            per_page: 0,
            page_count: 0
        }
    },
    loading: true,
    error: null,
})

export type ParamsT = {
    page: number,
    filter: {
        name: string|null,
        family: string|null,
    }
}
export const getFruits = async (params: ParamsT) => {
    return await client.get("/fruit", {params: params})
        .then((response) => {
            fruitRef.fruits = response.data;
            fruitRef.loading = false;
        }).catch((error) => {
            fruitRef.error = error;
            fruitRef.loading = false;
        }).finally(() => {
            fruitRef.loading = false;
        });
};

export const getNutrients = async (fruitId: number) => {
    return await client.get("/fruit/nutrients", {params: {fruit_id: fruitId}})
        .then((response) => {
            return response.data;
        }).catch((error) => {
            fruitRef.error = error;
            fruitRef.loading = false;
        }).finally(() => {
            fruitRef.loading = false;
        });
}
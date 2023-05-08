import {client} from "./client";
import {reactive} from "vue";

export type FruitRefT = {
    fruits: unknown[],
    loading: boolean,
    error: any,
}
export const fruitRef: FruitRefT = reactive({
    fruits: [],
    loading: true,
    error: null,
})

export type ParamsT = {
    page: number,
    pageSize: number,
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
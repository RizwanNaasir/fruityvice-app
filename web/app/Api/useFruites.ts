import {client} from "./client";
import {reactive} from "vue";

export const fruitRef = reactive({
    fruits: [],
    loading: true,
    error: null,
})
export const getFruits = async () => {

    return await client.get("/fruit")
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
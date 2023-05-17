<script setup lang="ts">
import { ref } from 'vue';
import { computed, watch } from "@vue/runtime-core";
import * as Validator from "validatorjs";
import AppHeader from '@/components/AppHeader.vue';
import FormField from '@/components/FormField.vue';
import BookInputs from '@/components/BookInputs.vue';
import DVDInputs from '@/components/DVDInputs.vue';
import FurnitureInputs from '@/components/FurnitureInputs.vue';
import { ProductInputsComponent } from '@/types/ProductInputsComponent';
import { productService, ProductInsertionError } from '@/services/productService';
import { APIValidationError } from '@/types/APIResponse';
import router from '@/router';

const PRODUCT_TYPE_TO_INPUTS_COMPONENT : Map<string, ProductInputsComponent> = new Map([
  ["book", BookInputs],
  ["dvd", DVDInputs],
  ["furniture", FurnitureInputs],
]);

const submitEl = ref<HTMLInputElement>(null);
const submited = ref(false);
const errors = ref(new Map());
const additionalInfo = {
    size: null,
    weight: null,
    width: null,
    length: null,
    height: null,
};

const form = ref({
    sku: null,
    name: null,
    price: null,
    type: null,
    ...additionalInfo
});

async function validate() {
    Validator.setMessages("en", await import(`validatorjs/src/lang/en`));
    const validator = new Validator({
        ...form.value
    }, {
        sku: 'required|regex:/^[0-9A-Za-z]+$/',
        name: 'required',
        price: 'required|numeric',
        type: 'required|in:book,dvd,furniture',
        weight: 'required_if:type,book|numeric',
        size: 'required_if:type,dvd',
        height: 'required_if:type,furniture|numeric',
        width: 'required_if:type,furniture|numeric',
        length: 'required_if:type,furniture|numeric',
    });

    errors.value.clear();

    if (validator.passes()) {
        return;
      }
      const errorsObject = validator.errors.all();
      for (const key of Object.keys(errorsObject)) {
        errors.value.set(key, errorsObject[key]);
      }
}

async function submit() {
    submited.value = true;
    await validate();
    if (errors.value.size > 0) return;
    saveProduct();
}

async function saveProduct() {
    const {
        name,
        price,
        sku,
        type,
        weight,
        size,
        width,
        height,
        length,
    } = form.value;
    try {
        await productService.insertProduct(
            name,
            price,
            sku,
            type,
            weight,
            size,
            width,
            height,
            length,
        );
        router.push({'name': 'home'});
    } catch(e:any) {
        const error = e as ProductInsertionError;

        for (const e of error.errors) {
            errors.value.set(e.key, e.errors);
        }
    }
}

const inputs = computed(() => {
  return PRODUCT_TYPE_TO_INPUTS_COMPONENT.get(form.value.type);
});

watch(() => ({...form.value}), (n, o) => {
    if (o.type != n.type) {
        Object.assign(form.value, additionalInfo);
    }
    if (submited.value) {
        validate();
    }
})
</script>
<template>
    <AppHeader title="Product Add">
        <template #action>
            <div class="header__content__buttons">
                <router-link :to="{'name': 'home'}" class="header__content__button">
                    Cancel
                </router-link>
                <button @click="submitEl.click()" class="header__content__button header__content__button--primary">
                    Save
                </button>
            </div>
        </template>
    </AppHeader>
    <main>
        <form class="form" @submit.prevent="submit">
            <FormField label="SKU" id="sku" :errors="errors.get('sku')">
                <input name="sku" v-model="form.sku" required class="form__field__input" id="sku" type="text" placeholder="Enter SKU..." />
            </FormField>

            <FormField label="Name" id="sku" :errors="errors.get('name')">
                <input v-model="form.name" required class="form__field__input" id="name" type="text" placeholder="Enter Name..." />
            </FormField>

            <FormField label="Price" id="sku" :errors="errors.get('price')">
                <input v-model="form.price" required class="form__field__input" id="price" type="number" placeholder="Enter Price..." />
            </FormField>

            <FormField label="Type" id="sku" :errors="errors.get('type')">
                <select v-model="form.type" required class="form__field__input" id="type">
                    <option :value="null">Select a type</option>
                    <option value="book">Book</option>
                    <option value="dvd">DVD</option>
                    <option value="furniture">Furniture</option>
                </select>
            </FormField>

            <component v-if="inputs" :is="inputs" :form="form" :errors="errors" />

            <input type="submit" style="display:none;" ref="submitEl">
        </form>
    </main>
</template>
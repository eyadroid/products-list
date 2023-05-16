<script setup lang="ts">
import { computed } from "@vue/runtime-core";
import { ref, onMounted } from 'vue';
import AppHeader from '@/components/AppHeader.vue';
import BookBox from '@/components/BookBox.vue';
import DVDBox from '@/components/DVDBox.vue';
import FurnitureBox from '@/components/FurnitureBox.vue';
import { ProductComponent } from '@/types/ProductComponent';
import Book from '@/models/Book';
import DVD from '@/models/DVD';
import Furniture from '@/models/Furniture';
import {useProductsStore} from "@/stores/products";

const selectedProducts = ref([]);

const productsStore = useProductsStore();
const { getProducts } = productsStore;

onMounted( async () => {
  await getProducts();
});

const products = computed(() => productsStore.products)

const PRODUCT_TYPE_TO_COMPONENT : Map<string, ProductComponent> = new Map([
  [Book.name, BookBox],
  [DVD.name, DVDBox],
  [Furniture.name, FurnitureBox],
]);

const showDeleteButton = computed(() => {
  return selectedProducts.value.length > 0;
});

async function deleteProducts() {
  productsStore.deleteProducts(selectedProducts.value);
  selectedProducts.value.splice(0);
}

function getComponentFromType (product:object):ProductComponent {
  return PRODUCT_TYPE_TO_COMPONENT.get(product.constructor.name)!;
}

function toggleProductSelection(product) {
  if (isProductSelected(product)) {
    selectedProducts.value.splice(selectedProducts.value.indexOf(product.id), 1);
    return;
  }

  selectedProducts.value.push(product.id);
  console.log(selectedProducts);
}

function isProductSelected(product) {
  return selectedProducts.value.indexOf(product.id) > -1;
}
</script>

<template>
  <AppHeader title="Product List">
    <template #action>
      <button @click="deleteProducts" class="header__content__button" v-if="showDeleteButton">
        MASS DELETE
      </button>

      <router-link :to="{'name': 'add'}" class="header__content__button" v-else>
        ADD
      </router-link>
    </template>
  </AppHeader>
  <main>
    <div class="product-list">
      <component :selected="isProductSelected(product)" @select="toggleProductSelection(product)" v-for="product of products" :key="product.id" :is="getComponentFromType(product)" :product="product" />
    </div>
  </main>
</template>

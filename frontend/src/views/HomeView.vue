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

const canDelete = computed(() => {
  return selectedProducts.value.length > 0;
});

async function deleteProducts() {
  if (!canDelete) return;
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
}

function isProductSelected(product) {
  return selectedProducts.value.indexOf(product.id) > -1;
}
</script>

<template>
  <AppHeader title="Product List">
    <template #action>
      <div class="header__content__buttons">
        <button v-if="canDelete" type="button" @click="selectedProducts.splice(0)" class="header__content__button header__content__button">
          DESELECT ALL
        </button>

        <button type="button" @click="deleteProducts" class="header__content__button header__content__button--primary">
          MASS DELETE
        </button>

        <router-link :to="{'name': 'add'}" class="header__content__button header__content__button--primary">
          ADD
        </router-link>
      </div>

    </template>
  </AppHeader>
  <main>
    <TransitionGroup name="products" tag="div" class="product-list">
      <component :selected="isProductSelected(product)" @select="toggleProductSelection(product)" v-for="product of products" :key="product.id" :is="getComponentFromType(product)" :product="product" />
    </TransitionGroup>
  </main>
</template>

<style>
.products-enter-active,
.products-leave-active {
  transition: all 0.5s ease;
}
.products-leave-to {
  opacity: 0;
  transform: scale(0) rotate(360deg);
}
</style>
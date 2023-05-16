import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import { productService } from '@/services/productService'

export const useProductsStore = defineStore('products', () => {
  const products = ref([])

  async function getProducts() {
    products.value = await productService.getProducts();
  }

  function findProductIndexById(id:number) {
    return products.value.findIndex((p) => p.id == id);
  }
  function deleteProducts(ids:number[]) {
    productService.deleteProducts(ids);
    ids.forEach((id) => products.value.splice(findProductIndexById(id), 1));
  }

  return { products, getProducts, deleteProducts }
})

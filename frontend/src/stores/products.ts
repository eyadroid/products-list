import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import { productService } from '@/services/productService'

export const useProductsStore = defineStore('products', () => {
  const products = ref([])

  async function insertProduct(
      name:string,
      price:number,
      sku:string,
      type:"book"|"dvd"|"furniture",
      weight:number|null = null,
      size:number|null = null,
      width:number|null = null,
      height:number|null = null,
      length:number|null = null,
    ) {
    return new Promise((resolve, reject) => {

      productService.insertProduct(
        name,
        price,
        sku,
        type,
        weight,
        size,
        width,
        height,
        length,
      ).then((product) => {
        const newProduct = new (productService.constructorFromType(product.type))(product);
        // if the product list is not empty insert the product
        // to it's start
        if (products.value.length > 0) {
          products.value.unshift(newProduct);
        } else {
          getProducts();
        }
        resolve(product);
      }).catch(e => reject(e));
    } 
    );
  }

  async function getProducts() {
    products.value = await productService.getProducts();
  }

  function findProductIndexById(id:number) {
    return products.value.findIndex((p) => p.id == id);
  }
  function deleteProducts(ids:number[]) {
    productService.deleteProducts(ids);
    // remove product from the list
    ids.forEach((id) => products.value.splice(findProductIndexById(id), 1));
  }

  return { products, getProducts, deleteProducts, insertProduct }
})

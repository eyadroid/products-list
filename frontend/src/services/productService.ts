import { productFactory } from '@/factories/productFactory'
import Product from '@/models/Product'
import { APIValidationError } from '@/types/APIResponse'
import { apiService } from './apiService'

export class ProductInsertionError extends Error {
  constructor(msg: string, public errors: APIValidationError[]) {
    super(msg)

    // Set the prototype explicitly.
    Object.setPrototypeOf(this, ProductInsertionError.prototype)
  }
}
class ProductService {
  async getProducts(): Promise<Product[]> {
    const resp = await apiService.get('/products')
    const json = resp.data as Array<any>
    // map json data to a product class by it's type
    return json.map<Product>((j) => productFactory.create(j))
  }

  async getProduct(sku: string): Promise<Product | null> {
    const resp = await apiService.get(`/products/get`, {
      sku
    })
    if (resp.success == false) {
      return null
    }
    const json = resp.data
    return productFactory.create(json)
  }

  async insertProduct(
    name: string,
    price: number,
    sku: string,
    type: 'book' | 'dvd' | 'furniture',
    weight: number | null = null,
    size: number | null = null,
    width: number | null = null,
    height: number | null = null,
    length: number | null = null
  ): Promise<any> {
    const resp = await apiService.post(`/products`, {
      name,
      price,
      type,
      sku,
      weight,
      size,
      width,
      height,
      length
    })

    if (resp.success == false) {
      const error = new ProductInsertionError(resp.message ?? 'Error occured', resp.errors ?? [])
      throw error
    }

    return resp.data
  }

  async deleteProducts(ids: number[]): Promise<boolean> {
    const resp = await apiService.delete(`/products`, {
      ids
    })

    if (!resp.success) {
      new Error(resp.message ?? 'Error occured')
    }
    return true
  }
}

export const productService = new ProductService()

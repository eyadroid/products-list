import Book from '@/models/Book'
import DVD from '@/models/DVD'
import Furniture from '@/models/Furniture'
import Product from '@/models/Product'
import ProductConstructor from '@/types/ProductConstructor'

// map to transform product type to it's corresponding constructor
export const typeToClassMap = new Map<String, ProductConstructor>([
  ['book', Book],
  ['dvd', DVD],
  ['furniture', Furniture]
])

class ProductFactory {
  // create a product from json data
  public create(json: any): Product {
    const constructor = this.constructorFromType(json.type)
    if (!constructor) throw new Error('Product type not found.')
    return new constructor(json)
  }

  private constructorFromType(type: string): ProductConstructor | undefined {
    return typeToClassMap.get(type)
  }
}

export const productFactory = new ProductFactory()

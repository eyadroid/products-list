import Book from '@/models/Book'
import DVD from '@/models/DVD'
import Furniture from '@/models/Furniture'

type ProductConstructor = typeof Book | typeof DVD | typeof Furniture

export default ProductConstructor

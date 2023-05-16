import Book from "@/models/Book";
import DVD from "@/models/DVD";
import Furniture from "@/models/Furniture";
import { typeToClassMap } from "@/services/productService";

type ProductConstructor = typeof Book|typeof DVD|typeof Furniture;

export default ProductConstructor;
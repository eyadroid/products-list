import Book from "@/models/Book";
import DVD from "@/models/DVD";
import Furniture from "@/models/Furniture";
import Product from "@/models/Product";
import { APIValidationError } from "@/types/APIResponse";
import ProductConstructor from "@/types/ProductConstructor";
import { apiService } from "./apiService";

export const typeToClassMap = new Map<String, ProductConstructor>([["book", Book],["dvd", DVD],["furniture", Furniture]]);

export class ProductInsertionError extends Error {
    constructor(msg:string, public errors: APIValidationError[]) {
        super(msg);
        
        // Set the prototype explicitly.
        Object.setPrototypeOf(this, ProductInsertionError.prototype);
    }
}
class ProductService {
    async getProducts():Promise<Product[]> {
        const resp = await apiService.get("/products");
        const json = (resp.data as Array<any>);
        return json.map<Product>((j) => new (this.constructorFromType(j.type))(j))
    }

    async getProduct(sku:string):Promise<Product> {
        const resp = await apiService.get(`/products/${sku}`);
        if (resp.success == false) {
            throw resp.message ?? "Error";
        }
        const json = resp.data;
        return new (this.constructorFromType(json.type))(json);
    }

    async insertProduct(
        name:string,
        price:number,
        sku:string,
        type:"book"|"dvd"|"furniture",
        weight:number|null = null,
        size:number|null = null,
        width:number|null = null,
        height:number|null = null,
        length:number|null = null,
    ):Promise<boolean> {
        const resp = await apiService.post(`/products`, {
            name,
            price,
            type,
            sku,
            weight,
            size,
            width,
            height,
            length,
        });

        if (resp.success == false) {
            const error = new ProductInsertionError(resp.message ?? "Error occured", resp.errors ?? []);
            throw error;
        }

        return true;
    }

    async deleteProducts(ids:number[]):Promise<boolean> {
        const resp = await apiService.delete(`/products`, {
            ids
        });

        if (!resp.success) {
            new Error(resp.message ?? "Error occured");
        }
        return true;
    }

    private constructorFromType(type:string): ProductConstructor {
        return typeToClassMap.get(type)!;
    }

}

export const productService = new ProductService();
import Product from "./Product";

export default class Book extends Product {
    public readonly weight:number;

    constructor(
        json:any
    ) {
        super(json);
        this.weight = json['weight'];
    }
}
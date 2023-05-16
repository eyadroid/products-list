import Product from "./Product";

export default class DVD extends Product {
    public readonly size:number;
    
    constructor(
        json:any
    ) {
        super(json);
        this.size = json['size'];
    }
}
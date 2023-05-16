export default abstract class Product {
    public readonly id:number;
    public readonly name:string;
    public readonly price:number;
    public readonly sku:string;
    constructor(
        json:any
    ) {
        this.id = json["id"];
        this.name = json["name"];
        this.price = json["price"];
        this.sku = json["sku"];
    }
}
import Product from './Product'

export default class Furniture extends Product {
  public readonly width: number
  public readonly heigth: number
  public readonly length: number

  constructor(json: any) {
    super(json)
    this.width = json['width']
    this.heigth = json['heigth']
    this.length = json['length']
  }
}

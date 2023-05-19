import Product from './Product'

export default class Furniture extends Product {
  public readonly width: number
  public readonly height: number
  public readonly length: number

  constructor(json: any) {
    super(json)
    this.width = json['width']
    this.height = json['height']
    this.length = json['length']
  }
}

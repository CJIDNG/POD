import { DefaultStatics } from './default'
import { UdemeStatics } from './udeme'
import { HCTStatics } from './healthcaretracka'

let Statics

switch (CurrentTenant.platform.name) {
  case "udeme":
    Statics = UdemeStatics
    break;

  case "healthcaretracka":
    Statics = HCTStatics
    break;

  default:
    Statics = DefaultStatics
    break;
}

export {
  Statics,
}

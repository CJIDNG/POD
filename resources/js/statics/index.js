import { DefaultStatics } from './default'
import { BOBStatics } from './bodyofbenchers'
import { HCTStatics } from './healthcaretracka'
import { UdemeStatics } from './udeme'

let Statics

switch (true) {
  case /bodyofbenchers/.test(CurrentTenant.platform.name):
    Statics = BOBStatics
    break;

  case /healthcaretracker/.test(CurrentTenant.platform.name):
    Statics = HCTStatics
    break;

  case /udeme/.test(CurrentTenant.platform.name):
    Statics = UdemeStatics
    break;

  default:
    Statics = DefaultStatics
    break;
}

export {
  Statics,
}

import { DefaultStatics } from './default'
import { BOBStatics } from './bodyofbenchers'
import { HCTStatics } from './healthcaretracka'
import { UdemeStatics } from './udeme'
import { FarukNasirStatics } from './faruknasir'
import { StarfolkSoftwareStatics } from './starfolksoftware'

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

  case /faruknasir/.test(CurrentTenant.platform.name):
    Statics = FarukNasirStatics
    break;

  case /starfolksoftware/.test(CurrentTenant.platform.name):
    Statics = StarfolkSoftwareStatics
    break;

  default:
    Statics = DefaultStatics
    break;
}

export {
  Statics,
}

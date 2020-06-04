import { DefaultStatics } from './default'
import { HCTStatics } from './healthcaretracka'
import { UdemeStatics } from './udeme'
import { SpoorStatics } from './spoor'
import { NAREPStatics } from './narep'
import { PTDataStatics } from './ptdata'

let Statics

switch (true) {
  case /healthcaretracker/.test(CurrentTenant.platform.name):
    Statics = HCTStatics
    break;

  case /udeme/.test(CurrentTenant.platform.name):
    Statics = UdemeStatics
    break;

  case /starfolksoftware/.test(CurrentTenant.platform.name):
    Statics = StarfolkSoftwareStatics
    break;
  
  case /spoor/.test(CurrentTenant.platform.name):
    Statics = SpoorStatics
    break;

  case /narepng/.test(CurrentTenant.platform.name):
    Statics = NAREPStatics
    break;

  case /ptdata/.test(CurrentTenant.platform.name):
    Statics = PTDataStatics
    break;

  default:
    Statics = DefaultStatics
    break;
}

export {
  Statics,
}

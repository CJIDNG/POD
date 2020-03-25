import { DefaultStatics } from './default'
import { BOBStatics } from './bodyofbenchers'

let Statics

switch (true) {
  case /bodyofbenchers/.test(CurrentTenant.platform.name):
    Statics = BOBStatics
    break;

  default:
    Statics = DefaultStatics
    break;
}

export {
  Statics,
}

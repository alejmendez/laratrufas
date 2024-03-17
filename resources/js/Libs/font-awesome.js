import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
  faBars,
  faSun,
  faMoon,
  faCircle,
  faChevronLeft,
  faChevronRight,
  faSort,
  faSortUp,
  faSortDown,
  faMagnifyingGlass,
  faEye,
  faPencil,
  faTrashCan,
  faCircleNotch,
  faAnglesLeft,
  faAnglesRight,
  faChevronDown,
  faPersonDigging,
  faArrowUpLong,
  faLocationDot,
  faVectorSquare,
  faTree,
  faTriangleExclamation,
  faCheck,
} from '@fortawesome/free-solid-svg-icons'

import { faBell, faCalendar }  from '@fortawesome/free-regular-svg-icons'

const icons = [
  faBars,
  faSun,
  faMoon,
  faCircle,
  faChevronLeft,
  faChevronRight,
  faSort,
  faSortUp,
  faSortDown,
  faMagnifyingGlass,
  faEye,
  faPencil,
  faTrashCan,
  faCircleNotch,
  faAnglesLeft,
  faAnglesRight,
  faChevronDown,
  faPersonDigging,
  faArrowUpLong,
  faLocationDot,
  faVectorSquare,
  faTree,
  faBell,
  faTriangleExclamation,
  faCalendar,
  faCheck,
]

export const initFontAwesome = (app) => {
  icons.map((i) => library.add(i))

  app.component('FontAwesomeIcon', FontAwesomeIcon)
}

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
} from '@fortawesome/free-solid-svg-icons'

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
]

export const initFontAwesome = (app) => {
  icons.map((i) => library.add(i))

  app.component('FontAwesomeIcon', FontAwesomeIcon)
}

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
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
  faPlus,
  faXmark,
  faSeedling,
  faTableCells,
  faTableCellsLarge,
  faFileInvoiceDollar,
  faListCheck,
  faTractor,
  faWrench,
  faHandshake,
  faUsers,
  faSquarePollVertical,
  faDog,
  faFileArrowUp,
  faBasketShopping,
  faBarcode,
  faRotateRight,
} from '@fortawesome/free-solid-svg-icons';

import { faBell, faCalendar } from '@fortawesome/free-regular-svg-icons';
import { faEnvira } from '@fortawesome/free-brands-svg-icons';

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
  faPlus,
  faXmark,
  faSeedling,
  faTableCells,
  faTableCellsLarge,
  faEnvira,
  faBasketShopping,
  faFileInvoiceDollar,
  faListCheck,
  faTractor,
  faWrench,
  faHandshake,
  faUsers,
  faSquarePollVertical,
  faDog,
  faFileArrowUp,
  faBarcode,
  faRotateRight,
];

export const initFontAwesome = (app) => {
  icons.map((i) => library.add(i));

  app.component('FontAwesomeIcon', FontAwesomeIcon);
};

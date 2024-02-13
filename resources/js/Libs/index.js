import { initFontAwesome } from './font-awesome'
import { initToast } from './toast'

export const initLibs = (app) => {
  initFontAwesome(app)
  initToast(app)
}

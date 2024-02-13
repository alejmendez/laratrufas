import { initFontAwesome } from './font-awesome'
import { initToast } from './toast'
import { initI18n } from './i18n'

export const initLibs = (app) => {
  initFontAwesome(app)
  initToast(app)
  initI18n(app)
}

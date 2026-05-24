export default {
  mounted(el) {
    if (el.tagName !== 'IMG') return

    el.style.opacity = '0'
    el.style.transition = 'opacity 0.6s ease-out'

    const show = () => { el.style.opacity = '1' }

    if (el.complete) {
      show()
    } else {
      el.addEventListener('load', show, { once: true })
    }
  }
}

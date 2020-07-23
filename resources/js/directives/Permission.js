import $ from 'jquery'
/**
 * The permission directive provides simple permission functionality for what a user can 
 * see or not see. To use this, add a `v-permission` directive to the element that should
 * show/hide it according to a users permission.
 *
 * For example:
 *
 * ```
 * <button v-permission="['admin']"></button>
 * ```
 *
 */

function hasPermissions(permissions) {
  permissions.forEach(permission => {
    if (CurrentTenant.user.permissions.includes(permission)) 
      return true
  })

  return false
}

const Permission = {
  bind(el, binding) {
    let permissions = binding.value

    if (Array.isArray(permissions) && !hasPermissions(permissions)) {
      $(el).hide()
    }
  },
}

export default Permission

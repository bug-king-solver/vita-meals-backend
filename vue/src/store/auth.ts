import { defineStore } from 'pinia'
import { computed, ref, Ref } from 'vue'
import { useRouter } from 'vue-router'
import Api from '../apis'
import { useFlash } from '../common/useFlash'
import { SignInPayload } from '../types'

interface User {
  // Define the shape of the User object here
  id: number;
  // Add more properties as needed
}

export const useAuthStore = defineStore('auth', () => {
    const router = useRouter()

    const { flash } = useFlash()

    const user: Ref<User | null> = ref(null)
    const token: Ref<string | null> = ref(null)

    function signin(payload: SignInPayload) {
      let errorStatus = ''

      Api
        .post('signin', payload)
        .then((response) => {
          const result = response.data
          if (!result.error) {
            user.value = result.user;
            token.value = result.authorisation.token;
            router.push("/");
          } else {
            flash({
                iconType: "error",
                title: "Auth Error",
                message: result.message
            })
          }
        })
        .catch((error) => {
          if (!error.response) {
            // network error
            errorStatus = 'Network Error'
          } else {
            errorStatus = error.response.data.message
          }
          flash({
                iconType: "error",
                title: "Auth Error",
                message: errorStatus
            })
        })
    }

    const isAuthenticated = computed(() => user.value !== null)
    const isTokenEmpty = computed(() => token.value === null)

    function signout() {
      if (isTokenEmpty.value) {
        flash({
                iconType: "error",
                title: "Auth Error",
                message: 'User is not authenticated!'
            })
        return
      }

      let errorStatus = '';

      Api
        .post('signout', {}, getHeadersConfig())
        .then((response) => {
          if (!response.data.error) {
            flash({
                iconType: "success",
                title: "Log out",
                message: response.data.message
            })
            user.value = null
            token.value = null
            router.push('/')
          }
        })
        .catch((error) => {
          if (!error.response) {
            // network error
            errorStatus = 'Network Error'
          } else {
            errorStatus = error.response.data.message
          }
          flash({
                iconType: "error",
                title: "Auth error",
                message: errorStatus
          })
        })
    }

    function getHeadersConfig() {
      return {
        headers: {
          Accept: 'application/json',
          Authorization: 'Bearer ' + (token.value || '') // Handle null token
        }
      }
    }
    return { user, token, signin, signout, isAuthenticated, getHeadersConfig }
  },
  {
    persist: true
  }
)
export default useAuthStore;

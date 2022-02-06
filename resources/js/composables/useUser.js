import { usePage } from '@inertiajs/inertia-vue3'

/**
 * Returns helper functions to determine the type of user currently logged in.
 * @returns 
 */
export default function useUser() {
    const isAdmin = usePage().props.value?.auth?.user.is_admin;

    /**
     * Checks if the currently logged in user is an admin.
     * @returns boolean
     */
    function userIsAdmin() {
        return isAdmin;
    }

    /**
     * Checks if the currently logged in user is a student.
     * @returns boolean
     */
    function userIsStudent() {
        return !isAdmin;
    }

    return { userIsAdmin, userIsStudent };
}
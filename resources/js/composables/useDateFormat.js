export default function useDateFormat() {
    /**
     * Formats the dates across the front-end of the application.
     * @param {Date|String} date 
     * @return String
     */
    function formatDate(date) {
        let formattedDate = new Date(date);
        let options = { year: 'numeric', month: 'long', day: 'numeric' };
        return formattedDate.toLocaleDateString('en-US', options);
    }

    return formatDate;
}
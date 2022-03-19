export default function useBookingTag() {

    /**
     * 
     * @param {Object} booking
     * @returns string
     */
    function bookingTag(booking) {
        if (!booking.eligible) return "Not Accepted";
        else {
            if (booking.accepted) return "Accepted"
            return "Pending..."
        }
    }

    return bookingTag;
}
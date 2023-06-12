export const notificationMessages =  {
    'login-prompt': 'Please login to book a slot',
    'logged-out': 'You are logged out',
    'logged-in': 'You are logged in',
    'booking-confirm': 'Booking confirmed',
    'booking-cancel': 'Booking cancelled',
    'weekend-prompt': 'We are closed on weekends',
}

export const headers =  () => {
    return {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('booking_token')}`
        }
    };
}

export const timesSlots =  ['9:00', '9:30', '10:00', '10:30', '11:00', '11:30',
    '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
    '15:00', '15:30', '16:00', '16:30', '17:00'];
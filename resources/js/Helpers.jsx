
// Getting date and time to today
export const isToday = (date) => {
    const today = new Date();
    return (
        date.getDate() === today.getDate() &&
        date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear()
    );
}

// Getting date and time to yesterday
export const isYesterday = (date) => {
    const today = new Date();
    today.setDate(today.getDate() - 1);
    return (
        date.getDate() === today.getDate() &&
        date.getDate() === today.getDate() &&
        date.getFullYear() === today.getFullYear()
    );
}


// Formating long date messages
export const formatMessageDateLong = (date) => {
    const nowDate = new Date();
    const inputDate = new Date(date);

    if(isToday(inputDate)) {
       return inputDate.toLocaleDateString([],{
           hour: '2-digit',
           minute: '2-digit',
       });
    }else if(isYesterday(inputDate)){
        return ("Yesterday " + inputDate.toLocaleDateString([], {
            hour: '2-digit',
            minute: '2-digit',
        }));
    }else if (inputDate.getFullYear() === nowDate.getFullYear()) {
        return inputDate.toLocaleDateString([], {
            day: '2-digit',
            month: 'short',
        })
    }else{
        return inputDate.toLocaleDateString();
    }
};

// Formating short date messages
export const formatMessageDateShort = (date) => {
    const nowDate = new Date();
    const inputDate = new Date(date);

    if(isToday(inputDate)) {
       return inputDate.toLocaleDateString([],{
           hour: '2-digit',
           minute: '2-digit',
       });
    }else if(isYesterday(inputDate)){
        return "Yesterday";
    }else if (inputDate.getFullYear() === nowDate.getFullYear()) {
        return inputDate.toLocaleDateString([], {
            day: '2-digit',
            month: 'short',
        })
    }else{
        return inputDate.toLocaleDateString();
    }
};

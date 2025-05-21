document.addEventListener('DOMContentLoaded', function() {
    const hoursDisplay = document.getElementById('hoursDisplay');
    const minutesDisplay = document.getElementById('minutesDisplay');
    const workMinutesInput = document.getElementById('workMinutes');

    document.querySelectorAll('.time-btn').forEach(button => {
        button.addEventListener('click', function() {
            const target = this.dataset.target; // 'hours' o 'minutes'
            const isIncrease = this.classList.contains('increase');

            let hours = parseInt(hoursDisplay.textContent, 10);
            let minutes = parseInt(minutesDisplay.textContent, 10);

            if (target === 'hours') {
                hours = isIncrease ? hours + 1 : Math.max(0, hours - 1);
            } else if (target === 'minutes') {
                // incrementar/decrementar en bloques de 1 minuto
                minutes = isIncrease ? minutes + 1 : minutes - 1;
                // ajuste de límites
                if (minutes >= 60) {
                    minutes -= 60;
                    hours += 1;
                } else if (minutes < 0) {
                    if (hours > 0) {
                        minutes += 60;
                        hours -= 1;
                    } else {
                        minutes = 0;
                    }
                }
            }

            // actualizar el display
            hoursDisplay.textContent = String(hours).padStart(2, '0');
            minutesDisplay.textContent = String(minutes).padStart(2, '0');
            // actualizar input oculto en minutos totales
            workMinutesInput.value = hours * 60 + minutes;
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    const dayColumns = document.querySelectorAll('.day-column');
    const hoverTask = document.getElementById('hoverTask');
    const taskModal = document.getElementById('taskModal');
    const closeModal = document.getElementById('closeModal');
    const taskForm = document.getElementById('taskForm');
    const taskDateInput = document.getElementById('taskDate');
    const prevWeekBtn = document.getElementById('prevWeek');
    const nextWeekBtn = document.getElementById('nextWeek');
    const weekRangeDisplay = document.getElementById('weekRange');
    const dayHeaders = document.querySelectorAll('.day-header');
    
    let currentWeekStart = new Date();
    currentWeekStart.setDate(currentWeekStart.getDate() - currentWeekStart.getDay() + 1); // Lunes de la semana actual
    let selectedDay = null;
    let draggedTask = null;
    let tasks = []; // Almacenará todas las tareas
    
    // Inicializar la aplicación
    initCalendar();
    
    // Función para inicializar el calendario
    function initCalendar() {
        updateWeekDisplay();
        markCurrentDay();
        setupEventListeners();
    }
    
    // Función para actualizar la visualización de la semana
    function updateWeekDisplay() {
        const weekEnd = new Date(currentWeekStart);
        weekEnd.setDate(weekEnd.getDate() + 6); // Domingo
        
        const formatOptions = { day: 'numeric', month: 'long', year: 'numeric' };
        const startStr = currentWeekStart.getDate();
        const endStr = `${weekEnd.getDate()} de ${weekEnd.toLocaleDateString('es-ES', { month: 'long', year: 'numeric' })}`;
        weekRangeDisplay.textContent = `${startStr} al ${endStr}`;
        
        // Actualizar los encabezados de los días
        dayHeaders.forEach((header, index) => {
            const date = new Date(currentWeekStart);
            date.setDate(date.getDate() + index);
            
            const dayName = date.toLocaleDateString('es-ES', { weekday: 'long' });
            const dayNumber = date.getDate().toString().padStart(2, '0');
            
            header.querySelector('.day-name').textContent = dayName.charAt(0).toUpperCase() + dayName.slice(1);
            header.querySelector('.day-number').textContent = dayNumber;
            
            // Asignar el atributo data-date a la columna correspondiente
            dayColumns[index].setAttribute('data-date', formatDate(date));
        });
        
        // Renderizar tareas para la semana actual
        renderTasks();
    }
    
    // Función para marcar el día actual
    function markCurrentDay() {
        const today = new Date();
        const dayOfWeek = today.getDay() - 1; // 0 para lunes, 6 para domingo
        
        // Verificar si el día actual está en la semana mostrada
        const weekEnd = new Date(currentWeekStart);
        weekEnd.setDate(weekEnd.getDate() + 6);
        
        if (today >= currentWeekStart && today <= weekEnd) {
            // Ajustar para que domingo sea 6 en lugar de 0
            const adjustedDayOfWeek = dayOfWeek === -1 ? 6 : dayOfWeek;
            dayHeaders[adjustedDayOfWeek].classList.add('current-day');
        } else {
            // Quitar la clase current-day de todos los días
            dayHeaders.forEach(header => header.classList.remove('current-day'));
        }
    }
    
    // Configurar los event listeners
    function setupEventListeners() {
        // Event listeners para navegación de semana
        prevWeekBtn.addEventListener('click', () => {
            currentWeekStart.setDate(currentWeekStart.getDate() - 7);
            updateWeekDisplay();
            markCurrentDay();
        });
        
        nextWeekBtn.addEventListener('click', () => {
            currentWeekStart.setDate(currentWeekStart.getDate() + 7);
            updateWeekDisplay();
            markCurrentDay();
        });
        
        // Event listener para el botón "HOY"
        document.querySelector('.btn-today').addEventListener('click', () => {
            const today = new Date();
            currentWeekStart = new Date(today);
            currentWeekStart.setDate(today.getDate() - today.getDay() + 1); // Lunes de la semana actual
            updateWeekDisplay();
            markCurrentDay();
        });
        
        // Event listeners para las columnas de días
        dayColumns.forEach((column, index) => {
            // Mostrar el cuadro flotante al pasar el cursor
            column.addEventListener('mousemove', (e) => {
                if (!taskModal.classList.contains('visible')) {
                    const rect = column.getBoundingClientRect();
                    hoverTask.style.left = `${e.clientX - 70}px`;
                    hoverTask.style.top = `${e.clientY - 20}px`;
                    hoverTask.classList.add('visible');
                    selectedDay = index;
                }
            });
            
            column.addEventListener('mouseleave', () => {
                hoverTask.classList.remove('visible');
            });
            
            // Abrir el modal al hacer clic
            column.addEventListener('click', (e) => {
                if (!e.target.closest('.task-item')) {
                    openTaskModal(index);
                }
            });
            
            // Eventos para drag and drop
            column.addEventListener('dragover', (e) => {
                e.preventDefault();
                column.classList.add('drag-over');
            });
            
            column.addEventListener('dragleave', () => {
                column.classList.remove('drag-over');
            });
            
            column.addEventListener('drop', (e) => {
                e.preventDefault();
                column.classList.remove('drag-over');
                if (draggedTask) {
                    const taskId = draggedTask.getAttribute('data-id');
                    const task = tasks.find(t => t.id === parseInt(taskId));
                    if (task) {
                        // Actualizar la fecha de la tarea
                        const newDate = new Date(currentWeekStart);
                        newDate.setDate(newDate.getDate() + index);
                        task.date = formatDate(newDate);
                        renderTasks();
                    }
                    draggedTask = null;
                }
            });
        });
        
        // Event listener para el cuadro flotante
        hoverTask.addEventListener('click', () => {
            openTaskModal(selectedDay);
        });
        
        // Event listeners para el modal
        closeModal.addEventListener('click', () => {
            taskModal.classList.remove('visible');
        });
        
        // Cerrar el modal al hacer clic fuera de él
        taskModal.addEventListener('click', (e) => {
            if (e.target === taskModal) {
                taskModal.classList.remove('visible');
            }
        });
        
        // Event listener para el formulario
        taskForm.addEventListener('submit', (e) => {
            e.preventDefault();
            saveTask();
        });
        
        // Event listeners para los controles de tiempo
        document.querySelectorAll('.time-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const target = btn.getAttribute('data-target');
                const isIncrease = btn.classList.contains('increase');
                updateTimeDisplay(target, isIncrease);
            });
        });
        
        // Event listener para eliminar tarea
        document.getElementById('deleteTask').addEventListener('click', () => {
            const taskId = taskForm.getAttribute('data-task-id');
            if (taskId) {
                deleteTask(parseInt(taskId));
            }
            taskModal.classList.remove('visible');
        });
    }
    
    // Función para abrir el modal de tarea
    function openTaskModal(dayIndex, taskId = null) {
        // Establecer la fecha en el formulario
        const date = new Date(currentWeekStart);
        date.setDate(date.getDate() + dayIndex);
        taskDateInput.value = formatDateDisplay(date);
        
        // Si se proporciona un ID de tarea, cargar los datos de la tarea
        if (taskId !== null) {
            const task = tasks.find(t => t.id === taskId);
            if (task) {
                document.getElementById('taskProject').value = task.project || '';
                document.getElementById('taskType').value = task.type || '';
                document.getElementById('taskDescription').value = task.description || '';
                
                // Establecer las horas y minutos
                const hours = Math.floor(task.minutes / 60);
                const minutes = task.minutes % 60;
                document.getElementById('hoursDisplay').textContent = hours.toString().padStart(2, '0');
                document.getElementById('minutesDisplay').textContent = minutes.toString().padStart(2, '0');
                
                // Establecer el ID de la tarea en el formulario
                taskForm.setAttribute('data-task-id', taskId);
                document.getElementById('deleteTask').style.display = 'block';
            }
        } else {
            // Resetear el formulario para una nueva tarea
            taskForm.reset();
            document.getElementById('hoursDisplay').textContent = '00';
            document.getElementById('minutesDisplay').textContent = '00';
            taskForm.removeAttribute('data-task-id');
            document.getElementById('deleteTask').style.display = 'none';
        }
        
        // Mostrar el modal
        taskModal.classList.add('visible');
        hoverTask.classList.remove('visible');
    }
    
    // Función para guardar una tarea
    function saveTask() {
        const taskId = taskForm.getAttribute('data-task-id');
        const date = parseDate(taskDateInput.value);
        const project = document.getElementById('taskProject').value;
        const type = document.getElementById('taskType').value;
        const description = document.getElementById('taskDescription').value;
        const hours = parseInt(document.getElementById('hoursDisplay').textContent);
        const minutes = parseInt(document.getElementById('minutesDisplay').textContent);
        const totalMinutes = hours * 60 + minutes;
        
        if (!description) {
            alert('Por favor, ingresa una descripción para la tarea.');
            return;
        }
        
        const task = {
            id: taskId ? parseInt(taskId) : Date.now(),
            date: formatDate(date),
            project,
            type,
            description,
            minutes: totalMinutes
        };
        
        if (taskId) {
            // Actualizar tarea existente
            const index = tasks.findIndex(t => t.id === parseInt(taskId));
            if (index !== -1) {
                tasks[index] = task;
            }
        } else {
            // Agregar nueva tarea
            tasks.push(task);
        }
        
        // Cerrar el modal y renderizar las tareas
        taskModal.classList.remove('visible');
        renderTasks();
    }
    
    // Función para eliminar una tarea
    function deleteTask(taskId) {
        const index = tasks.findIndex(t => t.id === taskId);
        if (index !== -1) {
            tasks.splice(index, 1);
            renderTasks();
        }
    }
    
    // Función para renderizar las tareas
    function renderTasks() {
        // Limpiar todas las columnas
        dayColumns.forEach(column => {
            column.innerHTML = '';
        });
        
        // Calcular el total de horas trabajadas y facturables
        let totalMinutesWorked = 0;
        
        // Renderizar las tareas para la semana actual
        tasks.forEach(task => {
            const taskDate = new Date(task.date);
            const weekStart = new Date(currentWeekStart);
            const weekEnd = new Date(currentWeekStart);
            weekEnd.setDate(weekEnd.getDate() + 6);
            
            // Verificar si la tarea está en la semana actual
            if (taskDate >= weekStart && taskDate <= weekEnd) {
                // Calcular el índice del día (0 para lunes, 6 para domingo)
                const dayIndex = Math.floor((taskDate - weekStart) / (24 * 60 * 60 * 1000));
                
                if (dayIndex >= 0 && dayIndex <= 6) {
                    // Crear el elemento de tarea
                    const taskElement = document.createElement('div');
                    taskElement.className = 'task-item';
                    taskElement.setAttribute('data-id', task.id);
                    taskElement.draggable = true;
                    
                    // Título de la tarea (usar el tipo o proyecto)
                    const title = task.type || task.project || 'Tarea sin título';
                    
                    // Formatear el tiempo
                    const hours = Math.floor(task.minutes / 60);
                    const minutes = task.minutes % 60;
                    const timeStr = `${hours}h ${minutes.toString().padStart(2, '0')}m`;
                    
                    taskElement.innerHTML = `
                        <div class="task-title">${title}</div>
                        <div class="task-description">${task.description}</div>
                        <div class="task-time">${timeStr}</div>
                    `;
                    
                    // Agregar la tarea a la columna correspondiente
                    dayColumns[dayIndex].appendChild(taskElement);
                    
                    // Actualizar el total de minutos trabajados
                    totalMinutesWorked += task.minutes;
                    
                    // Event listener para abrir el modal al hacer clic en la tarea
                    taskElement.addEventListener('click', (e) => {
                        e.stopPropagation();
                        openTaskModal(dayIndex, task.id);
                    });
                    
                    // Event listeners para drag and drop
                    taskElement.addEventListener('dragstart', () => {
                        draggedTask = taskElement;
                        setTimeout(() => {
                            taskElement.style.opacity = '0.5';
                        }, 0);
                    });
                    
                    taskElement.addEventListener('dragend', () => {
                        taskElement.style.opacity = '1';
                    });
                }
            }
        });
        
        // Actualizar los totales en la cabecera
        updateTotals(totalMinutesWorked);
    }
    
    // Función para actualizar los totales en la cabecera
    function updateTotals(totalMinutes) {
        const hours = Math.floor(totalMinutes / 60);
        const minutes = totalMinutes % 60;
        const timeStr = `${hours}h ${minutes.toString().padStart(2, '0')}m`;
        
        document.getElementById('totalHoursWorked').textContent = timeStr;
        document.getElementById('totalHoursBillable').textContent = timeStr; // Asumimos que todas son facturables
        
        // Actualizar las horas por día
        const dayTotals = {};
        
        tasks.forEach(task => {
            const date = task.date;
            if (!dayTotals[date]) {
                dayTotals[date] = 0;
            }
            dayTotals[date] += task.minutes;
        });
        
        // Actualizar las horas mostradas en cada encabezado de día
        dayColumns.forEach((column, index) => {
            const date = column.getAttribute('data-date');
            const minutes = dayTotals[date] || 0;
            const hours = Math.floor(minutes / 60);
            const mins = minutes % 60;
            const timeStr = `${hours}h ${mins.toString().padStart(2, '0')}m`;
            
            dayHeaders[index].querySelector('.day-hours').textContent = timeStr;
        });
    }
    
    // Función para actualizar la visualización del tiempo
    function updateTimeDisplay(target, isIncrease) {
        const display = document.getElementById(`${target}Display`);
        let value = parseInt(display.textContent);
        
        if (isIncrease) {
            if (target === 'hours') {
                value = (value + 1) % 24;
            } else {
                value = (value + 15) % 60; // Incrementar en bloques de 15 minutos
            }
        } else {
            if (target === 'hours') {
                value = (value - 1 + 24) % 24;
            } else {
                value = (value - 15 + 60) % 60; // Decrementar en bloques de 15 minutos
            }
        }
        
        display.textContent = value.toString().padStart(2, '0');
    }
    
    // Funciones de utilidad para formatear fechas
    function formatDate(date) {
        return `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`;
    }
    
    function formatDateDisplay(date) {
        return `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${date.getFullYear()}`;
    }
    
    function parseDate(dateStr) {
        const parts = dateStr.split('/');
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }
});
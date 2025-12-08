import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function () {
    const chartOptions = {
        responsive: true,
        plugins: { legend: { position: 'right' } }
    };

    const {
        usersLastYear,
        usersByRoles,
        eventsMonthly,
        eventsByType,
        userEventsByType,
        userEventsLastMonth,
        usersLastWeek,
        eventsLastWeek,
        userEventsLastWeek
    } = window.dashboardData;

    function getPastelColors(count) {
        const baseColors = [
            [93, 165, 218],  // modrá
            [250, 164, 58],  // oranžová
            [96, 189, 104],  // zelená
            [241, 124, 176], // ružová
            [178, 118, 178], // fialová
            [222, 207, 63]   // žltá
        ];
        const colors = [];
        for (let i = 0; i < count; i++) {
            const [r,g,b] = baseColors[i % baseColors.length];
            colors.push(`rgba(${r},${g},${b},0.7)`);
        }
        return colors;
    }

    /* USERS LAST YEAR (LINE) */
    new Chart(document.getElementById('usersLastYearChart'), {
        type: 'line',
        data: {
            labels: usersLastYear.map(u => u.month),
            datasets: [{
                label: 'Registrations',
                data: usersLastYear.map(u => u.count),
                borderWidth: 2,
            }]
        },
        options: chartOptions
    });

    /* USERS BY ROLES (doughnut) */
    new Chart(document.getElementById('usersByRolesChart'), {
        type: 'doughnut',
        data: {
            labels: usersByRoles.map(u => u.role),
            datasets: [{
                data: usersByRoles.map(u => u.count)
            }]
        },
        options: chartOptions
    });

    /* EVENTS MONTHLY (LINE) */
    new Chart(document.getElementById('eventsMonthlyChart'), {
        type: 'line',
        data: {
            labels: eventsMonthly.map(e => e.day),
            datasets: [{
                label: 'Events',
                data: eventsMonthly.map(e => e.count),
                borderWidth: 2
            }]
        },
        options: chartOptions
    });

    /* EVENTS BY TYPE (pie) */
    new Chart(document.getElementById('eventsByTypeChart'), {
        type: 'pie',
        data: {
            labels: eventsByType.map(e => e.type),
            datasets: [{
                data: eventsByType.map(e => e.count)
            }]
        },
        options: chartOptions
    });

    /* USER EVENTS BY TYPE (POLAR AREA) */
    new Chart(document.getElementById('userEventsByTypeChart'), {
        type: 'polarArea',
        data: {
            labels: userEventsByType.map(u => u.type),
            datasets: [{
                data: userEventsByType.map(u => u.count)
            }]
        },
        options: chartOptions
    });

    /* USER EVENTS LAST MONTH (BAR) */
    new Chart(document.getElementById('userEventsLastMonthChart'), {
        type: 'bar',
        data: {
            labels: userEventsLastMonth.map(u => u.day),
            datasets: [{
                label: 'Events',
                data: userEventsLastMonth.map(u => u.count),
                borderWidth: 1,
                backgroundColor: getPastelColors(userEventsLastMonth.length)
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, stepSize: 1 },
                x: { title: { display: true, text: 'Day' } }
            },
            plugins: { legend: { display: false } }
        }
    });

    /* USERS LAST WEEK (BAR) — NEW */
    new Chart(document.getElementById('usersLastWeekChart'), {
        type: 'bar',
        data: {
            labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            datasets: [{
                label: 'Users',
                data: usersLastWeek.map(d => d.count),
                borderWidth: 1,
                backgroundColor: getPastelColors(usersLastWeek.length)
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    /* EVENTS LAST WEEK (BAR) — NEW */
    new Chart(document.getElementById('eventsLastWeekChart'), {
        type: 'bar',
        data: {
            labels: eventsLastWeek.map(d => d.day),
            datasets: [{
                label: 'Events',
                data: eventsLastWeek.map(d => d.count),
                borderWidth: 1,
                backgroundColor: getPastelColors(eventsLastWeek.length)
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    /* USER EVENTS LAST WEEK (BAR) — NEW */
    new Chart(document.getElementById('userEventsLastWeekChart'), {
        type: 'bar',
        data: {
            labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            datasets: [{
                label: 'User Events',
                data: userEventsLastWeek.map(d => d.count),
                borderWidth: 1,
                backgroundColor: getPastelColors(userEventsLastWeek.length)
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
});

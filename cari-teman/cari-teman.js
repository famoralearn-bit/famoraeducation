/* =============================================
   MathLearn - Cari Teman JS
   ============================================= */

document.addEventListener('DOMContentLoaded', function () {

    // Filter online by default on page load
    const defaultTab = document.querySelector('.filter-tab.active');
    if (defaultTab) filterUsers('online', defaultTab);

    // Start polling for real-time online status
    startOnlinePolling();
});

// ---- Filter Tabs ----
function filterUsers(type, btn) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.user-card[data-status]').forEach(card => {
        if (type === 'all') {
            card.classList.remove('hidden');
        } else {
            card.dataset.status === type
                ? card.classList.remove('hidden')
                : card.classList.add('hidden');
        }
    });
}

// ---- Real-time polling ----
function startOnlinePolling() {
    setInterval(fetchOnlineStatus, 30000);
}

function fetchOnlineStatus() {
    fetch('../cari-teman/online-status.php')
        .then(res => res.json())
        .then(data => {
            if (!data || !data.users) return;

            let onlineCount = 0;
            let offlineCount = 0;

            data.users.forEach(u => {
                const card = document.querySelector(`.user-card[data-user-id="${u.id}"]`);
                if (!card) return;

                const dotEl   = card.querySelector('.online-dot');
                const labelEl = card.querySelector('.status-label');
                const isOn    = u.is_online;

                if (isOn) {
                    onlineCount++;
                    card.classList.add('is-online');
                    card.classList.remove('is-offline');
                    card.dataset.status = 'online';
                    if (dotEl)   dotEl.className   = 'online-dot online';
                    if (labelEl) { labelEl.className = 'status-label online'; labelEl.innerHTML = '<span class="dot"></span> Online'; }

                    if (!card.querySelector('.btn-discord')) {
                        const a = document.createElement('a');
                        a.className   = 'btn-discord';
                        a.href        = data.discord_link || '#';
                        a.target      = '_blank';
                        a.innerHTML   = '💬 Ajak Belajar';
                        card.appendChild(a);
                    }
                } else {
                    offlineCount++;
                    card.classList.remove('is-online');
                    card.classList.add('is-offline');
                    card.dataset.status = 'offline';
                    if (dotEl)   dotEl.className   = 'online-dot offline';
                    if (labelEl) { labelEl.className = 'status-label offline'; labelEl.innerHTML = '<span class="dot"></span> Offline'; }
                    const existing = card.querySelector('.btn-discord');
                    if (existing) existing.remove();
                }
            });

            const el = id => document.getElementById(id);
            if (el('online-count'))  el('online-count').textContent  = onlineCount;
            if (el('offline-count')) el('offline-count').textContent = offlineCount;
            if (el('total-count'))   el('total-count').textContent   = onlineCount + offlineCount;
        })
        .catch(() => { /* silently fail */ });
}

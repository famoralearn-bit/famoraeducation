function filterUsers(status, btn) {
    document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.user-card-wrap').forEach(card => {
        if (status === 'all') {
            card.style.display = '';
        } else {
            card.style.display = card.dataset.status === status ? '' : 'none';
        }
    });
}

// AJAX poll online status every 30s
setInterval(function () {
    fetch('online-status.php')
        .then(r => r.json())
        .then(data => {
            let online = 0, total = 0;
            document.querySelectorAll('.user-card-wrap').forEach(wrap => {
                const uid = wrap.dataset.userId;
                const isOnline = data[uid] || false;
                total++;
                if (isOnline) online++;
                wrap.dataset.status = isOnline ? 'online' : 'offline';

                const dot = wrap.querySelector('.online-dot');
                const lbl = wrap.querySelector('.status-label');
                if (dot) { dot.className = 'online-dot ' + (isOnline ? 'online' : 'offline'); }
                if (lbl) {
                    lbl.className = 'status-label ' + (isOnline ? 'online' : 'offline') + ' mb-2';
                    lbl.textContent = isOnline ? '🟢 Online' : '⚫ Offline';
                }
            });
            const onlineEl  = document.getElementById('online-count');
            const offlineEl = document.getElementById('offline-count');
            const totalEl   = document.getElementById('total-count');
            if (onlineEl)  onlineEl.textContent  = online;
            if (offlineEl) offlineEl.textContent = total - online;
            if (totalEl)   totalEl.textContent   = total;
        })
        .catch(() => {});
}, 30000);
